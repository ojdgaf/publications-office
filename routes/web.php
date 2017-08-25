<?php

Auth::routes();

//=============================================================================
    // MAIN
//=============================================================================
Route::get('/', 'PageController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');


//=============================================================================
    // SEARCH
//=============================================================================
Route::get('/search', 'SearchController@index')
    ->name('search.index');
Route::post('/search/basic', 'SearchController@basic')
    ->name('search.basic');
Route::post('/search/advanced', 'SearchController@advanced')
    ->name('search.advanced');


//=============================================================================
    // PUBLICATIONS
//=============================================================================
Route::get('/publications/filter', 'PublicationController@filter')
    ->name('publications.filter');
Route::resource('/publications', 'PublicationController');


//=============================================================================
    // AUTHORS
//=============================================================================
Route::get('/authors/filter', 'AuthorController@filter')
    ->name('authors.filter');
Route::resource('/authors', 'AuthorController');


//=============================================================================
    // LITERATURE
//=============================================================================
Route::get('/literature/filter', 'LiteratureController@filter')
    ->name('literature.filter');
Route::resource('/literature', 'LiteratureController');


//=============================================================================
    // DATABASES
//=============================================================================
Route::get('/databases/filter', 'DatabaseController@filter')
    ->name('databases.filter');
Route::resource('/databases', 'DatabaseController');

//=============================================================================
    // AJAX
//=============================================================================
Route::get(
    '/search/ajax/{entity}',
    'AJAXController@getSearchForm'
);

Route::get(
    '/publications/ajax/author/{number}',
    'AJAXController@getAuthorForm'
);
Route::get(
    '/publications/ajax/literature-titles/{type}/{publicationId?}',
    'AJAXController@getLiteratureTitles'
);
Route::get(
    '/publications/ajax/literature/{literatureId}/{publicationId?}',
    'AJAXController@getLiteratureForm'
);

Route::get(
    '/authors/ajax/for-student/{id?}',
    'AJAXController@getStudentForm'
);
Route::get(
    '/authors/ajax/for-staff/{id?}',
    'AJAXController@getStaffForm'
);

Route::get(
    '/literature/ajax/database/{number}',
    'AJAXController@getDatabaseForm'
);
Route::get(
    '/literature/ajax/for-journal/{id?}',
    'AJAXController@getJournalForm'
);
Route::get(
    '/literature/ajax/for-book-or-proceedings/{id?}',
    'AJAXController@getBookOrProceedingsForm'
);
