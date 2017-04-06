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

	public function getQueries()
	{
		return view('pages/queries');
	}

	public function getProfile()
	{
		return view('pages/profile');
	}
	
}