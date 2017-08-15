<?php

Auth::routes();

//=============================================================================
    // MAIN
//=============================================================================

Route::get('/', 'PageController@index');
Route::get('/home', 'HomeController@index')->name('home');


//=============================================================================
    // SEARCH
//=============================================================================

// -------------------------------------- AJAX ------------------------------->
Route::get('/search/ajax/{entity}', 'SearchController@addForm');
// -------------------------------------- RESOURCE --------------------------->
Route::get('/search', 'SearchController@index')->name('search.index');
Route::post('/search/basic', 'SearchController@basic')->name('search.basic');
Route::post('/search/advanced', 'SearchController@advanced')->name('search.advanced');


//=============================================================================
    // PUBLICATIONS
//=============================================================================

// -------------------------------------- AJAX ------------------------------->
Route::get('/publications/ajax/author-form/{number}', 'PublicationController@addAuthorForm');
Route::get('/publications/ajax/literature-titles/{type}/{publicationId?}', 'PublicationController@addLiteratureTitles');
Route::get('/publications/ajax/literature-form/{literatureId}/{publicationId?}', 'PublicationController@addLiteratureForm');
// -------------------------------------- RESOURCE --------------------------->
Route::get('/publications/filter', 'PublicationController@filter')->name('publications.filter');
Route::resource('/publications', 'PublicationController');


//=============================================================================
    // AUTHORS
//=============================================================================

// -------------------------------------- AJAX ------------------------------->
Route::get('/authors/form-student/{id?}', 'AuthorController@addStudentForm');
Route::get('/authors/form-staff/{id?}', 'AuthorController@addStaffForm');
// -------------------------------------- RESOURCE --------------------------->
Route::get('/authors/filter', 'AuthorController@filter')->name('authors.filter');
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
Route::get('/literature/filter', 'LiteratureController@filter')->name('literature.filter');
Route::resource('/literature', 'LiteratureController');


//=============================================================================
    // DATABASES
//=============================================================================

// -------------------------------------- RESOURCE --------------------------->
Route::get('/databases/filter', 'DatabaseController@filter')->name('databases.filter');
Route::resource('/databases', 'DatabaseController');
