<?php
// Welcome
Route::get('/', function () { return view('welcome'); });

// Authentication Routes
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/nightly/export', 'ExportController@run');
Route::get('/docs', function () { return view('docs'); });

// Credential Routes
Route::get('/credentials', 'CredentialController@fetch');
Route::post('/credentials', 'CredentialController@store');
Route::patch('/credentials/sync/{status}', 'CredentialController@update');

// Location Routes
Route::get('/locations', 'LocationController@index');
Route::get('/locations/all', 'LocationController@all');
Route::get('/locations/count', 'LocationController@count');
Route::get('/locations/store', 'LocationController@store');
Route::put('/locations/{id}', 'LocationController@update');
Route::get('/locations/export', 'LocationController@export');

// Staff Routes
Route::get('/staff', 'StaffController@index');
Route::get('/staff/datatable', 'StaffController@datatable');
Route::get('/staff/count', 'StaffController@count');
Route::get('/staff/store', 'StaffController@store');
Route::get('/staff/export', 'StaffController@export');

// Student Routes
Route::get('/students', 'StudentController@index');
Route::get('/students/datatable', 'StudentController@datatable');
Route::get('/students/count', 'StudentController@count');
Route::get('/students/store', 'StudentController@store');
Route::get('/students/export', 'StudentController@export');

// Course Routes
Route::get('/courses', 'CourseController@index');
Route::get('/courses/datatable', 'CourseController@datatable');
Route::get('/courses/count', 'CourseController@count');
Route::get('/courses/store', 'CourseController@store');
Route::get('/courses/export', 'CourseController@export');

// Section Routes
Route::get('/sections', 'SectionController@index');
Route::get('/sections/datatable', 'SectionController@datatable');
Route::get('/sections/count', 'SectionController@count');
Route::get('/sections/store', 'SectionController@store');
Route::get('/sections/export', 'SectionController@export');

// Roster Routes
Route::get('/rosters', 'RosterController@index');
Route::get('/rosters/datatable', 'RosterController@datatable');
Route::get('/rosters/count', 'RosterController@count');
Route::get('/rosters/store', 'RosterController@store');
Route::get('/rosters/export', 'RosterController@export');
