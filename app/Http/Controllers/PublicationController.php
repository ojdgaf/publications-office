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

        return view('pages/publications/index')
            ->withPublications($publications);
    }

    public function create()
    {
        return view('pages/publications/create')
            ->withGenres(Publication::getPublicationGenres())
            ->withTypes(Publication::getPublicationTypes())

            ->withAuthors(Author::all())
            ->withStatuses(Author::getAuthorStatuses());
    }

    public function store(StorePublication $request)
    {
        $id = DB::transaction(function() use ($request) {
            $publication = new Publication();
            $this->fill($publication, $request);
            $publication->document_path = $this->storeFile(
                                              $request->heading,
                                              $request->file('document')
                                          );
            $publication->save();

            $this->storeAuthors(
                $publication->id,
                $request->id_author,
                $request->status_author
            );

            return $publication->id;
        }, 5);

        return redirect()->route('publications.show', $id)
            ->with('success', 'New publication was successfully saved');
    }

    public function show($id)
    {
        $publication = Publication::find($id);

        if (!$publication) {
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');
        }

        return view('pages/publications/show')
            ->withPublication($publication);
    }

    public function edit($id)
    {
        $publication = Publication::find($id);

        if (!$publication) {
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');
        }

        return view('pages/publications/edit')
            ->withPublication($publication)
            ->withGenres(Publication::getPublicationGenres())
            ->withTypes(Publication::getPublicationTypes())

            ->withAuthors(Author::all())
            ->withStatuses(Author::getAuthorStatuses())

            ->withLiterature(Literature::all());
    }

    public function update(StorePublication $request, $id)
    {
        $publication = Publication::find($id);

        if (!$publication) {
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');
        }

        DB::transaction(function() use ($request, &$publication) {
            $this->fill($publication, $request);
            $publication->document_path = $this->updateFile(
                                              $request->heading,
                                              $request->file('document'),
                                              $publication->document_path
                                          );
            $publication->save();

            // delete all previous related authors
            AuthorPublication::where('publication_id', $publication->id)->delete();

            // add new authors
            $this->storeAuthors(
                $publication->id,
                $request->id_author,
                $request->status_author
            );
        }, 5);

        return redirect()->route('publications.show', $publication->id)
            ->with('success', 'Publication was successfully updated');
    }

    public function destroy($id)
    {
        $publication = Publication::find($id);

        if (!$publication) {
            return redirect()->route('publications.index')
                ->with('error', 'Such publication doesn\'t exist!');
        }

        DB::transaction(function() use (&$publication) {
            Storage::delete($publication->document_path);
            AuthorPublication::where('publication_id', $publication->id)->delete();
            $publication->delete();
        }, 5);

        return redirect()->route('publications.index')
            ->with('success', 'Publication was successfully deleted');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    public function filter(Request $request)
    {
        $publications = Publication::filter($request->all());

        if ($publications->isEmpty()) {
            return redirect()->route('publications.index')
                ->with('error', 'No matching publications found');
        }

        return view('pages/publications/index')
            ->withPublications($publications);
    }

    private function fill(&$publication, $request)
    {
        $publication->heading =         $request->heading;
        $publication->abstract =        $request->abstract;
        $publication->description =     $request->description;
        $publication->genre =           $request->genre;
        $publication->type =            $request->type;
        $publication->literature_id =   $request->literature_id;
        $publication->issue_number =    $request->issue_number;
        $publication->issue_year =      $request->issue_year;
        $publication->page_initial =    $request->page_initial;
        $publication->page_final =      $request->page_final;
    }

    private function storeAuthors($publicationId, $ids, $statuses)
    {
        if (!empty($ids) && !empty($statuses)) {
            for ($i = 0; $i < 5; $i++) {
                if ( isset($ids[$i]) && isset($statuses[$i]) ) {
                    $publicationAuthor = new AuthorPublication();

                    $publicationAuthor->author_id           = $ids[$i];
                    $publicationAuthor->publication_id      = $publicationId;
                    $publicationAuthor->status_author       = $statuses[$i];

                    $publicationAuthor->save();
                }
            }
        }
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

    public function addAuthorForm()
    {
        return view('pages/publications/create-update parts/_form-author')
            ->withAuthors(Author::all())
            ->withStatuses(Author::getAuthorStatuses());
    }

    public function addLiteratureTitles($type, $publicationId = null)
    {
        $literature = null;
        $type = str_replace('_', ' ', $type);

        // find literature according to chosen type
        if (in_array($type, Literature::getLiteratureTypes())) {
            $literature = Literature::where('type', $type)->get();
        }

        // publication id is given - mark related literature
        if ($publicationId) {
            $literatureActive = Publication::find($publicationId)->literature;

            if ($literatureActive->type == $type) {
                return view('pages/publications/create-update parts/_form-literature-titles')
                    ->with('literatureActive', $literatureActive)
                    ->withLiterature($literature);
            }
        }

        return view('pages/publications/create-update parts/_form-literature-titles')
            ->withLiterature($literature);
    }

    public function addLiteratureForm($literatureId, $publicationId = null)
    {
        $literature = Literature::find($literatureId);

        $viewPath = $literature->type == 'journal' ? 'journal' : 'book-or-proceedings';

        // return view for edit
        if ($publicationId) {
            $publication = Publication::find($publicationId);

            if ($publication->literature_id == $literatureId) {
                return view('pages/publications/create-update parts/_form-' . $viewPath)
                    ->withPublication($publication)
                    ->withLiterature($literature);
            }
        }

        // return view for create
        return view('pages/publications/create-update parts/_form-' . $viewPath)
            ->withLiterature($literature);
    }
}
