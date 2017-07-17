<?php

namespace App\Http\Controllers;

use App\Literature;
use App\DatabaseLiterature;
use App\Database;

use App\Http\Requests\StoreLiterature;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LiteratureController extends Controller
{
    //======================================================================
    // RESOURCE MAIN METHODS
    //======================================================================

    public function index()
    {
        $literature = Literature::orderBy('title')->paginate(10);

        return view('pages/literature/index')
            ->withLiterature($literature);
    }

    public function create()
    {
        return view('pages/literature/create')
            ->withTypes(Literature::getLiteratureTypes())
            ->withDatabases(Database::all());
    }

    public function store(StoreLiterature $request)
    {
        $id = DB::transaction(function() use ($request) {
            $literature = new Literature();
            $this->fill($literature, $request);

            // cover image is given
            if ($request->hasFile('cover')) {
                $literature->cover_path = $request
                                              ->file('cover')
                                              ->store('literature/covers');
            }

            $literature->save();

            $this->storeDatabases(
                $literature->id,
                $request->id_database,
                $request->date_database
            );

            return $literature->id;
        }, 5);

        return redirect()->route('literature.show', $id)
            ->with('success', 'New literature was successfully saved');
    }

    public function show($id)
    {
        $literature = Literature::find($id);

         if (!$literature) {
            return redirect()->route('literature.index')
                ->with('error', 'Such literature doesn\'t exist!');
        }

        return view('pages/literature/show')
            ->withLiterature($literature);
    }

    public function edit($id)
    {
        $literature = Literature::find($id);

        if (!$literature) {
            return redirect()->route('literature.index')
                ->with('error', 'Such literature doesn\'t exist!');
        }

        return view('pages/literature/edit')
            ->withLiterature($literature)
            ->withDatabases(Database::all())
            ->withTypes(Literature::getLiteratureTypes());
    }

    public function update(StoreLiterature $request, $id)
    {
        $literature = Literature::find($id);

        if (!$literature) {
            return redirect()->route('literature.index')
                ->with('error', 'Such literature doesn\'t exist!');
        }

        DB::transaction(function() use ($request, &$literature) {
            $this->fill($literature, $request);
            $literature->cover_path = $this->updateFile(
                                          $request->file('cover'),
                                          $literature->cover_path
                                      );
            $literature->save();

            // delete all previous related databases
            DatabaseLiterature::where('literature_id', $literature->id)->delete();

            // add new databases
            $this->storeDatabases(
                $literature->id,
                $request->id_database,
                $request->date_database
            );
        }, 5);

        return redirect()->route('literature.show', $literature->id)
            ->with('success', 'Literature was successfully updated');
    }

    public function destroy($id)
    {
        $literature = Literature::find($id);

        if (!$literature) {
            return redirect()->route('literature.index')
                ->with('error', 'Such literature doesn\'t exist!');
        }

        DB::transaction(function() use (&$literature) {
            DatabaseLiterature::where('literature_id', $literature->id)->delete();
            $literature->delete();
        }, 5);

        return redirect()->route('literature.index')
            ->with('success', 'Literature was successfully deleted');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    public function filter(Request $request)
    {
        $literature = Literature::filter('title', $request->all());

        if ($literature->isEmpty()) {
            return redirect()->route('literature.index')
                ->with('error', 'No matching literature found');
        }

        return view('pages/literature/index')
            ->withLiterature($literature);
    }

    private function fill(&$literature, $request)
    {
        $literature->title =           $request->title;
        $literature->description =     $request->description;
        $literature->publisher =       $request->publisher;
        $literature->type =            $request->type;
        $literature->periodicity =     $request->periodicity;
        $literature->issn =            $request->issn;
        $literature->size =            $request->size;
        $literature->issue_year =      $request->issue_year;
        $literature->isbn =            $request->isbn;
    }

    private function storeDatabases($literature_id, $ids, $dates)
    {
        if (!empty($ids) && !empty($dates)) {
            for ($i = 0; $i < 5; $i++) {
                if ( isset($ids[$i]) && isset($dates[$i]) ) {
                    $literatureDatabase = new DatabaseLiterature();

                    $literatureDatabase->database_id =      $ids[$i];
                    $literatureDatabase->literature_id =    $literature_id;
                    $literatureDatabase->date =             $dates[$i];

                    $literatureDatabase->save();
                }
            }
        }
    }

    private function updateFile($newFile, $oldFilePath)
    {
        if ($newFile) {
            if ($oldFilePath) Storage::delete($oldFilePath);
            return $newFile->store('literature/covers');
        }

        return $oldFilePath;
    }

    //======================================================================
    // AJAX REQUESTS' CONTROLLERS
    //======================================================================

    public function addDatabaseForm()
    {
        return view('pages/literature/create-update parts/_form-database')
            ->withDatabases(Database::all());
    }

    public function addJournalForm($id = null)
    {
        // return view for edit
        if ($id) {
            $literature = Literature::find($id);

            if ($literature) {
                return view('pages/literature/create-update parts/_form-journal')
                    ->withLiterature($literature)
                    ->withPeriodicities(Literature::getLiteraturePeriodicities());
            }
        }

        // return view for create
        return view('pages/literature/create-update parts/_form-journal')
            ->withPeriodicities(Literature::getLiteraturePeriodicities());
    }

    public function addBookOrProceedingsForm($id = null)
    {
        // return view for edit
        if ($id) {
            $literature = Literature::find($id);

            if ($literature) {
                return view('pages/literature/create-update parts/_form-book-or-proceedings')
                    ->withLiterature($literature);
            }
        }

        // return view for create
        return view('pages/literature/create-update parts/_form-book-or-proceedings');
    }
}
