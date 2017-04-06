<?php

namespace App\Http\Controllers;

use App\Author;
use App\AuthorPublication;
use App\Publication;

use App\Http\Requests\StoreAuthor;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

// TRY NOT TO DELETE RECORDS FROM AUTHOR-PUBLICATION, JUST MARK EM AS 'DELETED'

class AuthorController extends Controller
{
    //======================================================================
    // RESOURCE MAIN METHODS
    //======================================================================

    public function index()
    {
        $authors = Author::orderBy('name')->paginate(10);

        return view('pages/authors/index')
            ->withAuthors($authors);
    }

    public function create()
    {
        return view('pages/authors/create')
            ->withStatuses(Author::getAuthorStatuses());
    }

    public function store(StoreAuthor $request)
    {
        $author = new Author();
        $this->fill($author, $request);
        $author->save();

        return redirect()->route('authors.show', $author->id)
            ->with('success', 'New author was successfully saved');
    }

    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')
                ->with('error', 'Such author doesn\'t exist!');
        }

        return view('pages/authors/show')
            ->withAuthor($author);
    }

    public function edit($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')
                ->with('error', 'Such author doesn\'t exist!');
        }

        return view('pages/authors/edit')
            ->withAuthor($author)
            ->withStatuses(Author::getAuthorStatuses());
    }

    public function update(StoreAuthor $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')
                ->with('error', 'Such author doesn\'t exist!');
        }

        $this->fill($author, $request);
        $author->save();

        return redirect()->route('authors.show', $author->id)
            ->with('success', 'Author ' . $author->name . ' was successfully updated');
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')
                ->with('error', 'Such author doesn\'t exist!');
        }

        AuthorPublication::where('author_id', $id)->delete();
        $author->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author was successfully deleted');
    }

    //======================================================================
    // RESOURCE ADDITIONAL METHODS
    //======================================================================

    private function fill(&$author, $request)
    {
        $author->name =             $request->name;
        $author->email =            $request->email;
        $author->status =           $request->status;
        $author->degree =           $request->degree;
        $author->rank =             $request->rank;
        $author->post =             $request->post;
    }

    //======================================================================
    // AJAX REQUESTS' CONTROLLERS
    //======================================================================

    public function addStudentForm($id = NULL)
    {
        // return view for edit
        if ($id) {
            $author = Author::find($id);

            if ($author) {
                return view('pages/authors/create-update parts/_form-student')
                    ->withAuthor($author)
                    ->withDegrees(Author::getAuthorStudentDegrees());
            }
        } 

        // return view for create
        return view('pages/authors/create-update parts/_form-student')
            ->withDegrees(Author::getAuthorStudentDegrees());
    }

    public function addStaffForm($id = NULL)
    {
        // return view for edit
        if ($id) {
            $author = Author::find($id);

            if ($author) {
                return view('pages/authors/create-update parts/_form-staff')
                    ->withAuthor($author)
                    ->withDegrees(Author::getAuthorStaffDegrees())
                    ->withRanks(Author::getAuthorRanks());
            }
        }

        // return view for create
        return view('pages/authors/create-update parts/_form-staff')
            ->withDegrees(Author::getAuthorStaffDegrees())
            ->withRanks(Author::getAuthorRanks());
    }
}
