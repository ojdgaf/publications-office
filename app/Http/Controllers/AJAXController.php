<?php

namespace App\Http\Controllers;

use App\Author;
use App\Database;
use App\Literature;
use App\Publication;
use Illuminate\Http\Request;

class AJAXController extends Controller
{
    //======================================================================
    // AUTHOR
    //======================================================================

    public function getStudentForm($id = null)
    {
        // return view for edit
        if ($id && $author = Author::findOrFail($id))
            return view('pages/authors/create-update parts/_form-student', [
                'author' => $author,
                'degrees' => Author::getAuthorStudentDegrees()
            ]);

        // return view for create
        return view('pages/authors/create-update parts/_form-student', [
            'degrees' => Author::getAuthorStudentDegrees()
        ]);
    }

    public function getStaffForm($id = null)
    {
        // return view for edit
        if ($id && $author = Author::findOrFail($id))
            return view('pages/authors/create-update parts/_form-staff', [
                'author' => $author,
                'degrees' => Author::getAuthorStaffDegrees(),
                'ranks' => Author::getAuthorRanks()
            ]);

        // return view for create
        return view('pages/authors/create-update parts/_form-staff', [
            'degrees' => Author::getAuthorStaffDegrees(),
            'ranks' => Author::getAuthorRanks()
        ]);
    }

    //======================================================================
    // LITERATURE
    //======================================================================

    public function getDatabaseForm($number)
    {
        return view('pages/literature/create-update parts/_form-database', [
            'databases' => Database::all(),
            'number' => $number
        ]);
    }

    public function getJournalForm($id = null)
    {
        // return view for edit
        if ($id && $literature = Literature::findOrFail($id))
            return view('pages/literature/create-update parts/_form-journal', [
                'literature' => $literature,
                'periodicities' => Literature::getLiteraturePeriodicities()
            ]);

        // return view for create
        return view('pages/literature/create-update parts/_form-journal', [
            'periodicities' => Literature::getLiteraturePeriodicities()
        ]);
    }

    public function getBookOrProceedingsForm($id = null)
    {
        // return view for edit
        if ($id && $literature = Literature::findOrFail($id))
            return view(
                'pages/literature/create-update parts/_form-book-or-proceedings',
                compact('literature')
            );

        // return view for create
        return view('pages/literature/create-update parts/_form-book-or-proceedings');
    }

    //======================================================================
    // PUBLICATION
    //======================================================================

    public function getAuthorForm($number)
    {
        return view('pages/publications/create-update parts/_form-author', [
            'authors' => Author::all(),
            'statuses' => Author::getAuthorStatuses(),
            'number' => $number
        ]);
    }

    public function getLiteratureTitles($type, $publicationId = null)
    {
        $literature = null;
        $type = str_replace('_', ' ', $type);

        // findOrFail literature according to chosen type
        if (in_array($type, Literature::getLiteratureTypes()))
            $literature = Literature::where('type', $type)->get();

        // publication id is given - mark related literature
        if ($publicationId) {
            $literatureActive = Publication::findOrFail($publicationId)->literature;

            if ($literatureActive->type == $type)
                return view(
                    'pages/publications/create-update parts/_form-literature-titles',
                    compact('literature', 'literatureActive')
                );
        }

        return view(
            'pages/publications/create-update parts/_form-literature-titles',
            compact('literature')
        );
    }

    public function getLiteratureForm($literatureId, $publicationId = null)
    {
        $literature = Literature::withTrashed()->findOrFail($literatureId);

        $viewPath = ($literature->type == 'journal') ? 'journal' : 'book-or-proceedings';

        // return view for edit
        if ($publicationId) {
            $publication = Publication::findOrFail($publicationId);

            if ($publication->literature_id == $literatureId) {
                return view(
                    'pages/publications/create-update parts/_form-' . $viewPath,
                    compact('publication', 'literature')
                );
            }
        }

        // return view for create
        return view(
            'pages/publications/create-update parts/_form-' . $viewPath,
            compact('literature')
        );
    }

    //======================================================================
    // SEARCH
    //======================================================================

    public function getSearchForm($entity)
    {
        switch ($entity) {
            case 'publication':
                return view('pages/search/parts/_form-' . $entity, [
                    'types' => Publication::getPublicationTypes(),
                    'genres' => Publication::getPublicationGenres()
                ]);

            case 'literature':
                return view('pages/search/parts/_form-' . $entity, [
                    'types' => Literature::getLiteratureTypes(),
                    'periodicities' => Literature::getLiteraturePeriodicities()
                ]);

            case 'author':
                return view('pages/search/parts/_form-' . $entity, [
                    'statuses' => Author::getAuthorStatuses(),
                    'degrees' => Author::getAuthorDegrees(),
                    'ranks' => Author::getAuthorRanks()
                ]);

            case 'database':
                return view('pages/search/parts/_form-' . $entity, [
                    'accessModes' => Database::getDatabaseAccessModes()
                ]);
        }

        return redirect()->route('search.index')
            ->with('error', 'Wrong request');
    }
}
