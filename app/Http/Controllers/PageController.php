<?php

namespace App\Http\Controllers;

use App\Publication;

class PageController extends Controller
{
	public function index()
	{
		$publications = Publication::orderBy('id', 'desc')->limit(6)->get();

		return view('pages/index')->withPublications($publications);
	}

	public function about()
	{
		return view('pages/about');
	}
}
