<?php

namespace App\Http\Controllers;

use App\Publication;
use App\AuthorPublication;
use App\Author;
use App\Literature;

use App\Http\Requests\StorePublication;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

// CHECK IF PAGES FOR NEW/UPDATED PUBLICATION ARE NOT ALREADY BOOKED

class PublicationController extends Controller
{
    //======================================================================
    // RESOURCE MAIN METHODS
    //======================================================================

    public function index()
    {
        $publications = Publication::orderBy('heading')->paginate(10);

        return view('pages/publications/index', compact('publications'));
    }

    public function create()
    {
        return view('pages/publications/create', [
            'genres' =>     Publication::getPublicationGenres(),
            'types' =>      Publication::getPublicationTypes(),
            'authors' =>    Author::all(),
            'statuses' =>   Author::getAuthorStatuses()
        ]);
    }

    public function store(StorePublication $request)
    {
        $id = DB::transaction(function() use (&$request) {
            $input = $request->all();
            $input['document_path'] = $this->storeFile(
                                        $request->heading,
                                        $request->file('document'));

            $publication = Publication::create($input);

            $publication->authors()->attach(
                $this->alterAuthorsArray($input['authors']));

            return $publication->id;
        }, 3);

        return redirect()->route('publications.show', $id)
            ->with('success', 'New publication was successfully saved');
    }

    public function show($id)
    {
        if (! $publication = Publication::find($id))
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');

        return view('pages/publications/show', compact('publication'));
    }

    public function edit($id)
    {
        if (! $publication = Publication::find($id))
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');

        return view('pages/publications/edit', [
            'publication' =>    $publication,
            'genres' =>         Publication::getPublicationGenres(),
            'types' =>          Publication::getPublicationTypes(),
            'authors' =>        Author::all(),
            'statuses' =>       Author::getAuthorStatuses(),
            'literature' =>     Literature::all()
        ]);
    }

    public function update(StorePublication $request, $id)
    {
        if (! $publication = Publication::find($id))
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');

        DB::transaction(function() use (&$request, &$publication) {
            $input = $request->all();
            $input['document_path'] = $this->updateFile(
                                        $request->heading,
                                        $request->file('document'),
                                        $publication->document_path);

            $publication->fill($input)->save();

            $publication->authors()->sync(
                $this->alterAuthorsArray($input['authors']));
        }, 3);

        return redirect()->route('publications.show', $publication->id)
            ->with('success', 'Publication was successfully updated');
    }

    public function destroy($id)
    {
        if (! $publication = Publication::find($id))
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');

        DB::transaction(function() use (&$publication) {
            Storage::delete($publication->document_path);
            $publication->authors()->detach();
            $publication->delete();
        }, 3);

        return redirect()->route('publications.index')
            ->with('success', 'Publication was successfully deleted');
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
    private function alterAuthorsArray($authors)
    {
        /*
            $authors = [
                1 => [author_id => 'X', 'status_author' => 'A'],
                ...
                5 => [author_id => 'Y', 'status_author' => 'B'],
            ]

            to

            $authors = [
                X => ['status_author' => A],
                ...
                Y => ['status_author' => B],
            ]
        */

        $result = [];

        foreach ($authors as $author) {
            $result[$author['author_id']] = [
                'status_author' => $author['status_author']
            ];
        }

        return $result;
    }

    public function filter(Request $request)
    {
        $publications = Publication::filterWithJoin($request->all());

        if ($publications->isEmpty())
            return redirect()->route('publications.index')
                ->with('error', 'No matching publications found');

        return view('pages/publications/index', compact('publications'));
    }

    private function storeFile($heading, $newFile)
    {
        $newName = preg_replace('([^\w\s\d\-_~,;\[\]\(\)])', '', $heading);
        $newExtension = $newFile->extension();
        return $newFile->storeAs('publications', $newName . '.' . $newExtension);
    }

    private function updateFile($heading, $newFile, $oldFilePath)
    {
        $newName = preg_replace('([^\w\s\d\-_~,;\[\]\(\)])', '', $heading);

        // update file
        if ($newFile) {
            $newExtension = $newFile->extension();
            Storage::delete($oldFilePath);
            return $newFile->storeAs('publications', $newName . '.' . $newExtension);
        }
        // update filename if necessary
        else {
            $oldExtension = (new Filesystem)->extension($oldFilePath);
            $newFilePath = 'publications/' . $newName . '.' . $oldExtension;
            if ($newFilePath != $oldFilePath) Storage::move($oldFilePath, $newFilePath);
            return $newFilePath;
        }
    }

    //======================================================================
    // AJAX REQUESTS' CONTROLLERS
    //======================================================================

    public function addAuthorForm($number)
    {
        return view('pages/publications/create-update parts/_form-author', [
            'authors' => Author::all(),
            'statuses' => Author::getAuthorStatuses(),
            'number' => $number
        ]);
    }

    public function addLiteratureTitles($type, $publicationId = null)
    {
        $literature = null;
        $type = str_replace('_', ' ', $type);

        // find literature according to chosen type
        if (in_array($type, Literature::getLiteratureTypes()))
            $literature = Literature::where('type', $type)->get();

        // publication id is given - mark related literature
        if ($publicationId) {
            $literatureActive = Publication::find($publicationId)->literature;

            if ($literatureActive->type == $type)
                return view(
                        'pages/publications/create-update parts/_form-literature-titles',
                        compact('literature', 'literatureActive'));
        }

        return view(
            'pages/publications/create-update parts/_form-literature-titles',
            compact('literature'));
    }

    public function addLiteratureForm($literatureId, $publicationId = null)
    {
        $literature = Literature::find($literatureId);

        $viewPath = ($literature->type == 'journal') ? 'journal' : 'book-or-proceedings';

        // return view for edit
        if ($publicationId) {
            $publication = Publication::find($publicationId);

            if ($publication->literature_id == $literatureId) {
                return view(
                    'pages/publications/create-update parts/_form-' . $viewPath,
                    compact('publication', 'literature'));
            }
        }

        // return view for create
        return view(
            'pages/publications/create-update parts/_form-' . $viewPath,
            compact('literature'));
    }
}
