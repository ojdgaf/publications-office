<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;
use App\Literature;
use App\Author;
use App\Database;

class SearchController extends Controller
{
    public function index()
	{
		return view('pages/search/index');
	}

    public function basic(Request $request)
    {
        $query = trim($request->input('query'));

        if (!$query)
            return redirect()->route('search.basic')
                ->with('error', 'Input query!');

        $publications = Publication::search($query)->get();
        $literature = Literature::search($query)->get();
        $authors = Author::search($query)->get();
        $databases = Database::search($query)->get();

        return view('pages/search/result')
            ->withPublications($publications)
            ->withLiterature($literature)
            ->withAuthors($authors)
            ->withDatabases($databases);
    }
}
