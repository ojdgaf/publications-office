<?php

namespace App\Http\Controllers;

use App\Publication;
use App\Literature;
use App\Author;
use App\Database;

use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;

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

        return view('pages/search/result')
            ->withPublications($publications)
            ->withLiterature($literature)
            ->withAuthors($authors)
            ->withDatabases($databases);
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
                return view('pages/search/result')
                    ->withPublications(
                        Publication::filterAndSearch($parameters, $query, 'heading', $interval)
                    );
            case 'literature':
                return view('pages/search/result')
                    ->withLiterature(
                        Literature::filterAndSearch($parameters, $query, 'title', $interval)
                );
            case 'author':
                return view('pages/search/result')
                    ->withAuthors(
                        Author::filterAndSearch($parameters, $query, 'name')
                );
            case 'database':
                return view('pages/search/result')
                    ->withDatabases(
                        Database::filterAndSearch($parameters, $query, 'name')
                    );
        }

        return redirect()->route('search.index')
            ->with('error', 'Wrong request');
    }

    //======================================================================
    // AJAX REQUESTS' CONTROLLERS
    //======================================================================

    public function addForm($entity)
    {
        switch ($entity) {
            case 'publication':
                return view('pages/search/parts/_form-' . $entity)
                    ->withTypes(Publication::getPublicationTypes())
                    ->withGenres(Publication::getPublicationGenres());

            case 'literature':
                return view('pages/search/parts/_form-' . $entity)
                    ->withTypes(Literature::getLiteratureTypes())
                    ->withPeriodicities(Literature::getLiteraturePeriodicities());

            case 'author':
                return view('pages/search/parts/_form-' . $entity)
                    ->withStatuses(Author::getAuthorStatuses())
                    ->withDegrees(Author::getAuthorDegrees())
                    ->withRanks(Author::getAuthorRanks());

            case 'database':
                return view('pages/search/parts/_form-' . $entity)
                    ->with('accessModes', Database::getDatabaseAccessModes());
        }

        return redirect()->route('search.index')
            ->with('error', 'Wrong request');
    }
}
