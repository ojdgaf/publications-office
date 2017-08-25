<?php

namespace App\Http\Controllers;

use App\Database;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDatabase;

class DatabaseController extends Controller
{
    public function index()
    {
        $databases = Database::orderBy('name')->paginate(10);

        return view('pages/databases/index', compact('databases'));
    }

    public function create()
    {
        return view('pages/databases/create', [
            'accessModes' => Database::getDatabaseAccessModes()
        ]);
    }

    public function store(StoreDatabase $request)
    {
        $database = Database::create($request->all());

        return redirect()->route('databases.show', $database->id)
            ->with('success', 'New database was successfully saved');
    }

    public function show(Database $database)
    {
        return view('pages/databases/show', compact('database'));
    }

    public function edit(Database $database)
    {
        return view('pages/databases/edit', [
            'database' => $database,
            'accessModes' => Database::getDatabaseAccessModes()
        ]);
    }

    public function update(StoreDatabase $request, $id)
    {
        $database = Database::findOrFail($id);

        $database->fill($request->all())->save();

        return redirect()->route('databases.show', $database->id)
            ->with('success', 'Database ' . $database->name . ' was successfully updated');
    }

    public function destroy(Database $database)
    {
        $database->literature()->detach();
        $database->delete();

        return redirect()->route('databases.index')
            ->with('success', 'Database was successfully deleted');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    public function filter(Request $request)
    {
        $databases = Database::filter('name', $request->all());

        if ($databases->isEmpty()) {
            return redirect()->route('databases.index')
                ->with('error', 'No matching databases found');
        }

        return view('pages/databases/index', compact('databases'));
    }
}
