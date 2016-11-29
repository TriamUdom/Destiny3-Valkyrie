<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/login', 'AdminController@showLoginPage');
Route::post('/login', 'AdminController@login');

// Authorization required beyond this point
Route::group(['middleware' => 'admin'], function(){
    Route::get('/', 'ApplicantController@showIndexPage');

    Route::get('/logout', 'AdminController@logout');

    Route::get('/applicants/{object_id}', 'ApplicantController@displayDocument');
    Route::post('/applicants/status/{object_id}', 'ApplicantController@updateAcceptanceStatus');
    Route::post('/applicants/{object_id}/{document}', 'ApplicantController@updateDocumentStatus');
});
