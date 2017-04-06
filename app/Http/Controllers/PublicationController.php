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
        // sanitize the given publication name
        $name = preg_replace("([^\w\s\d\-_~,;/\[\]\(\)])", '', $heading);

        // find out extension
        $extension = $newFile->extension();

        // save new file and return the path
        return $newFile->storeAs('publications', $name . '.' . $extension);
    }

    private function updateFile($heading, $newFile, $oldFilePath)
    {
        // sanitize the given publication name
        $name = preg_replace("([^\w\s\d\-_~,;/\[\]\(\)])", '', $heading);

        // there's an update with new file
        if ($newFile) {
            // find out extension
            $extension = $newFile->extension();

            //delete previous file
            Storage::delete($oldFilePath);

            // save new file and return the path
            return $newFile->storeAs('publications', $name . '.' . $extension);
        }

        // there's an update without new file
        else {
            // find out extension 
            $extension = (new Filesystem)->extension($oldFilePath);
            
            // create full file name
            $newFilePath = 'publications/' . $name . '.' . $extension;

            // rename existing file
            Storage::move($oldFilePath, $newFilePath);

            // return the result
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

    public function addLiteratureForm($type, $id = null)
    {
        $literature = null;
        $type = str_replace('_', ' ', $type);

        // find literature according to chosen type
        if (in_array($type, Literature::getLiteratureTypes())) {
            $literature = Literature::where('type', $type)->get();
        }

        // publication id is given - mark related literature
        if ($id) {
            $literatureActive = Publication::find($id)->literature;

            if ($literatureActive->type == $type) {
                return view('pages/publications/create-update parts/_form-literature')
                    ->with('literatureActive', $literatureActive)
                    ->withLiterature($literature);
            }
        }

        return view('pages/publications/create-update parts/_form-literature')
            ->withLiterature($literature);       
    }

    public function addJournalForm($id = null)
    {
        // return view for edit
        if ($id) {
            $publication = Publication::find($id);

            if ($publication) {
                return view('pages/publications/create-update parts/_form-journal')
                    ->withPublication($publication);
            }
        } 

        // return view for create
        return view('pages/publications/create-update parts/_form-journal');
    }

    public function addPagesForm($id = null)
    {
        // return view for edit
        if ($id) {
            $publication = Publication::find($id);

            if ($publication) {
                return view('pages/publications/create-update parts/_form-pages')
                    ->withPublication($publication);
            }
        } 
        
        // return view for create
        return view('pages/publications/create-update parts/_form-pages'); 
    }
}
