<?php

namespace App\Http\Controllers;

use App\Literature;
use App\Database;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLiterature;
use Illuminate\Support\Facades\Storage;

class LiteratureController extends Controller
{
    public function index()
    {
        $literature = Literature::orderBy('title')->paginate(10);

        return view('pages/literature/index', compact('literature'));
    }

    public function create()
    {
        return view('pages/literature/create', [
            'types' => Literature::getLiteratureTypes(),
            'databases' => Database::all()
        ]);
    }

    public function store(StoreLiterature $request)
    {
        $input = $request->all();

        if ($request->hasFile('cover'))
            $input['cover_path'] = $request
                                    ->file('cover')
                                    ->store('literature/covers');

        $literature = Literature::create($input);

        $literature->databases()->attach(
            $this->alterDatabasesArray($input['databases']));

        return redirect()->route('literature.show', $literature->id)
            ->with('success', 'New literature was successfully saved');
    }

    public function show(Literature $literature)
    {
        return view('pages/literature/show', compact('literature'));
    }

    public function edit(Literature $literature)
    {
        return view('pages/literature/edit', [
            'literature' => $literature,
            'databases' => Database::all(),
            'types' => Literature::getLiteratureTypes()
        ]);
    }

    public function update(StoreLiterature $request, $id)
    {
        $literature = Literature::findOrFail($id);

        $input = $request->all();
        $input['cover_path'] = $this->updateFile(
                                      $request->file('cover'),
                                      $literature->cover_path);

        $literature->fill($input)->save();

        $literature->databases()->sync(
            $this->alterDatabasesArray($input['databases']));

        return redirect()->route('literature.show', $literature->id)
            ->with('success', 'Literature was successfully updated');
    }

    public function destroy(Literature $literature)
    {
        Storage::delete($literature->cover_path);
        $literature->databases()->detach();
        $literature->delete();

        return redirect()->route('literature.index')
            ->with('success', 'Literature was successfully deleted');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    /**
     * Return suitable array for attach() method
     *
     * @var array
     * @return array
     */
    private function alterDatabasesArray($databases)
    {
        $result = [];

        if (! isset($databases[1]['database_id']))
            return $result;

        foreach ($databases as $database) {
            $result[$database['database_id']] = [
                'date' => $database['date']
            ];
        }

        return $result;
    }

    public function filter(Request $request)
    {
        $literature = Literature::filter('title', $request->all());

        if ($literature->isEmpty()) {
            return redirect()->route('literature.index')
                ->with('error', 'No matching literature found');
        }

        return view('pages/literature/index', compact('literature'));
    }

    private function updateFile($newFile, $oldFilePath)
    {
        if ($newFile) {
            if ($oldFilePath) Storage::delete($oldFilePath);
            return $newFile->store('literature/covers');
        }

        return $oldFilePath;
    }
}
