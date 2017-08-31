<?php

namespace App\Http\Controllers;

use App\Publication;
use App\Author;
use App\Literature;
use Illuminate\Http\Request;
use App\Http\Requests\StorePublication;

// CHECK IF PAGES FOR NEW/UPDATED PUBLICATION ARE NOT ALREADY BOOKED

class PublicationController extends Controller
{
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
        $input = $request->all();

        $input['document_path'] =
            StorageController::storePublicationFile(
                $request->heading,
                $request->file('document')
        );

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

        $input['document_path'] =
            StorageController::updatePublicationFile(
                $request->heading,
                $request->file('document'),
                $publication->document_path
        );

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
     * @param array
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
}
