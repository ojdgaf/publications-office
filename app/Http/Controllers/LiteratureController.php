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
        $itemType = 'index';
        $literature = Literature::orderBy('title')->paginate(10);

        return view('pages/literature/index', compact('literature', 'itemType'));
    }

    public function archive()
    {
        $itemType = 'archival';
        $literature = Literature::onlyTrashed()->orderBy('title')->paginate(10);

        return view('pages/literature/index', compact('literature', 'itemType'));
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
        $literature->remove();

        return redirect()->route('literature.index')
            ->with('success', 'Literature was successfully deleted');
    }

    public function forceDestroy($id)
    {
        $literature = Literature::onlyTrashed()->findOrFail($id);

        if ($literature->publications->isNotEmpty())
            return redirect()->route('literature.archive')
                ->with('error', 'Cannot delete literature with related publications');

        $literature->databases()->detach();

        $literature->forceDelete();

        return redirect()->route('literature.archive')
            ->with('success', 'Literature has been completely deleted');
    }

    public function restore($id)
    {
        $literature = Literature::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('literature.archive')
        ->with('success', 'Literature has been successfully restored');
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
        $itemType = 'index';
        $literature = Literature::filter('title', $request->all());

        if ($literature->isEmpty())
            return redirect()->route('literature.index')
                ->with('error', 'No matching literature found');

        return view('pages/literature/index', compact('literature', 'itemType'));
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
