<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuthor;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::orderBy('name')->paginate(10);

        return view('pages/authors/index', compact('authors'));
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

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    public function filter(Request $request)
    {
        $authors = Author::filter('name', $request->all());

        if ($authors->isEmpty())
            return redirect()->route('authors.index')
                ->with('error', 'No matching authors found');

        return view('pages/authors/index', compact('authors'));
    }
}
