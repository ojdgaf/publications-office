<?php

//=============================================================================
    // MAIN
//=============================================================================

Route::get('/', 'PageController@index');
Route::get('/queries', 'PageController@getQueries');
Route::get('/profile', 'PageController@getProfile');


//=============================================================================
    // PUBLICATIONS
//=============================================================================

// -------------------------------------- AJAX ------------------------------->
Route::get('/publications/form-author', 'PublicationController@addAuthorForm');
Route::get('/publications/literature/{type}/{id?}', 
	'PublicationController@addLiteratureForm');
Route::get('/publications/form-journal/{id?}', 'PublicationController@addJournalForm');
Route::get('/publications/form-pages/{id?}', 'PublicationController@addPagesForm');
// -------------------------------------- RESOURCE --------------------------->
Route::get('/publications/filter', 'PublicationController@filter')
	->name('publications.filter');

Route::resource('/publications', 'PublicationController');


//=============================================================================
    // AUTHORS
//=============================================================================

// -------------------------------------- AJAX ------------------------------->
Route::get('/authors/form-student/{id?}', 'AuthorController@addStudentForm');
Route::get('/authors/form-staff/{id?}', 'AuthorController@addStaffForm');
// -------------------------------------- RESOURCE --------------------------->
Route::resource('/authors', 'AuthorController');


//=============================================================================
    // LITERATURE
//=============================================================================

// -------------------------------------- AJAX ------------------------------->
Route::get('/literature/form-database/', 'LiteratureController@addDatabaseForm');
Route::get('/literature/form-journal/{id?}', 'LiteratureController@addJournalForm');
Route::get('/literature/form-book-proceedings/{id?}', 
	'LiteratureController@addBookOrProceedingsForm');
// -------------------------------------- RESOURCE --------------------------->
Route::resource('/literature', 'LiteratureController');
