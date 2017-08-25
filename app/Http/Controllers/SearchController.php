<?php

namespace App\Http\Controllers;

use App\Publication;
use App\Literature;
use App\Author;
use App\Database;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;

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
            return redirect()->route('search.index')
                ->with('error', 'Input query!');

        $publications = Publication::search($query)->get();
        $literature = Literature::search($query)->get();
        $authors = Author::search($query)->get();
        $databases = Database::search($query)->get();

        return view(
            'pages/search/result',
            compact('publications', 'literature', 'authors', 'databases')
        );
    }

    public function advanced(SearchRequest $request)
    {
        $parameters = $request->all();
        $query = trim($parameters['query']);
        $entity = $parameters['entity'];

        $interval = isset($parameters['interval']) ?
            explode(' - ', $parameters['interval']) : null;

        unset(
            $parameters['query'],
            $parameters['entity'],
            $parameters['interval'],
            $parameters['_token']
        );

        switch ($entity) {
            case 'publication':
                return view('pages/search/result', ['publications' =>
                    Publication::filterAndSearch($parameters, $query, 'heading', $interval)
                ]);
            case 'literature':
                return view('pages/search/result', ['literature' =>
                    Literature::filterAndSearch($parameters, $query, 'title', $interval)
                ]);
            case 'author':
                return view('pages/search/result', ['authors' =>
                    Author::filterAndSearch($parameters, $query, 'name')
                ]);
            case 'database':
                return view('pages/search/result', ['databases' =>
                    Database::filterAndSearch($parameters, $query, 'name')
                ]);
        }

        return redirect()->route('search.index')
            ->with('error', 'Wrong request');
    }
}
