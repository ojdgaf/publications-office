<?php

namespace App\Http\Controllers;

use App\Database;
use App\DatabaseLiterature;
use App\Http\Requests\StoreDatabase;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    //======================================================================
    // RESOURCE MAIN METHODS
    //======================================================================

    public function index()
    {
        $databases = Database::orderBy('name')->paginate(10);

        return view('pages/databases/index')
            ->withDatabases($databases);
    }

    public function create()
    {
        return view('pages/databases/create')
            ->with('accessModes', Database::getDatabaseAccessModes());
    }

    public function store(StoreDatabase $request)
    {
        $database = new Database();
        $this->fill($database, $request);
        $database->save();

        return redirect()->route('databases.show', $database->id)
            ->with('success', 'New database was successfully saved');
    }

    public function show($id)
    {
        $database = Database::find($id);

        if (!$database) {
            return redirect()->route('databases.index')
                ->with('error', 'Such database doesn\'t exist!');
        }

        return view('pages/databases/show')
            ->withDatabase($database);
    }

    public function edit($id)
    {
        $database = Database::find($id);

        if (!$database) {
            return redirect()->route('databases.index')
                ->with('error', 'Such database doesn\'t exist!');
        }

        return view('pages/databases/edit')
            ->withDatabase($database)
            ->with('accessModes', Database::getDatabaseAccessModes());
    }

    public function update(StoreDatabase $request, $id)
    {
        $database = Database::find($id);

        if (!$database) {
            return redirect()->route('databases.index')
                ->with('error', 'Such database doesn\'t exist!');
        }

        $this->fill($database, $request);
        $database->save();

        return redirect()->route('databases.show', $database->id)
            ->with('success', 'Database ' . $database->name . ' was successfully updated');
    }

    public function destroy($id)
    {
        $database = Database::find($id);

        if (!$database) {
            return redirect()->route('databases.index')
                ->with('error', 'Such database doesn\'t exist!');
        }

        DatabaseLiterature::where('database_id', $id)->delete();
        $database->delete();

        return redirect()->route('databases.index')
            ->with('success', 'Database was successfully deleted');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    private function fill(&$database, $request)
    {
        $database->name =             $request->name;
        $database->description =      $request->description;
        $database->url =              $request->url;
        $database->access_mode =      $request->access_mode;
    }
}
