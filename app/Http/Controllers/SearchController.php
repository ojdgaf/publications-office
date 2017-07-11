<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
	{
		return view('pages/search/index');
	}

    public function search(Request $request)
    {
        return view('pages/search/result');
    }
}
