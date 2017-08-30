<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthor;

class AuthorController extends Controller
{
    public function index()
    {
        $itemType = 'index';
        $authors = Author::orderBy('name')->paginate(10);

        return view('pages/authors/index', compact('authors', 'itemType'));
    }

    public function archive()
    {
        $itemType = 'archival';
        $authors = Author::onlyTrashed()->orderBy('name')->paginate(10);

        return view('pages/authors/index', compact('authors', 'itemType'));
    }

    public function create()
    {
        return view('pages/authors/create', [
            'statuses' => Author::getAuthorStatuses()
        ]);
    }

    public function store(StoreAuthor $request)
    {
        $author = Author::create($request->all());

        return redirect()->route('authors.show', $author->id)
            ->with('success', 'New author was successfully saved');
    }

    public function show(Author $author)
    {
        return view('pages/authors/show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('pages/authors/edit', [
            'author' => $author,
            'statuses' => Author::getAuthorStatuses()
        ]);
    }

    public function update(StoreAuthor $request, $id)
    {
        $author = Author::findOrFail($id);

        $author->fill($request->all())->save();

        return redirect()->route('authors.show', $author->id)
            ->with('success', 'Author ' . $author->name . ' was successfully updated');
    }

    public function destroy(Author $author)
    {
        $author->remove();

        return redirect()->route('authors.index')
            ->with('success', 'Author was successfully deleted');
    }

    public function forceDestroy($id)
    {
        $author = Author::onlyTrashed()->findOrFail($id);

        $author->publications()->detach();

        $author->forceDelete();

        return redirect()->route('authors.archive')
            ->with('success', 'Author has been completely deleted');
    }

    public function restore($id)
    {
        $author = Author::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('authors.archive')
            ->with('success', 'Author has been successfully restored');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    public function filter(Request $request)
    {
        $itemType = 'index';
        $authors = Author::filter('name', $request->all());

        if ($authors->isEmpty())
            return redirect()->route('authors.index')
                ->with('error', 'No matching authors found');

        return view('pages/authors/index', compact('authors', 'itemType'));
    }
}
