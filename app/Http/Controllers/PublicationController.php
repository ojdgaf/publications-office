<?php

namespace App\Http\Controllers;

use App\Publication;
use App\Author;
use App\Literature;
use Illuminate\Http\Request;
use App\Http\Requests\StorePublication;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

// CHECK IF PAGES FOR NEW/UPDATED PUBLICATION ARE NOT ALREADY BOOKED

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::orderBy('heading')->paginate(10);

        return view('pages/publications/index', compact('publications'));
    }

    public function archival()
    {
        dd('ass');
        $publications = Publication::onlyTrashed()
            ->orderBy('heading')
            ->paginate(10);

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
        $input = $request->all();

        $input['document_path'] = $this->storeFile(
                                    $request->heading,
                                    $request->file('document'));

        $publication = Publication::create($input);

        $publication->authors()->attach(
            $this->alterAuthorsArray($input['authors'])
        );

        return redirect()->route('publications.show', $publication->id)
            ->with('success', 'New publication was successfully saved');
    }

    public function show(Publication $publication)
    {
        return view('pages/publications/show', compact('publication'));
    }

    public function edit(Publication $publication)
    {
        return view('pages/publications/edit', [
            'publication'   =>      $publication,
            'genres'        =>      Publication::getPublicationGenres(),
            'types'         =>      Publication::getPublicationTypes(),
            'authors'       =>      Author::all(),
            'statuses'      =>      Author::getAuthorStatuses(),
            'literature'    =>      Literature::all()
        ]);
    }

    public function update(StorePublication $request, $id)
    {
        $publication = Publication::findOrFail($id);

        $input = $request->all();
        $input['document_path'] = $this->updateFile(
                                    $request->heading,
                                    $request->file('document'),
                                    $publication->document_path);

        $publication->fill($input)->save();

        $publication->authors()->sync(
            $this->alterAuthorsArray($input['authors'])
        );

        return redirect()->route('publications.show', $publication->id)
            ->with('success', 'Publication was successfully updated');
    }

    public function destroy(Publication $publication)
    {
        $publication->remove();

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

        if ($newFile) {
            // replace file
            $newExtension = $newFile->extension();
            Storage::delete($oldFilePath);
            return $newFile->storeAs('publications', $newName . '.' . $newExtension);
        } else {
            // update filename if necessary
            $oldExtension = (new Filesystem)->extension($oldFilePath);
            $newFilePath = 'publications/' . $newName . '.' . $oldExtension;
            if ($newFilePath != $oldFilePath) Storage::move($oldFilePath, $newFilePath);
            return $newFilePath;
        }
    }
}
