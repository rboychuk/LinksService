<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/links/{id}', 'LinkController@getLinks');

Route::post('/search', 'LinkController@searchLinks');
Route::post('/add_link', 'LinkController@addLinks');
Route::post('/update', 'LinkController@updateLinks');
Route::post('/delete', 'LinkController@deleteLink');
Route::post('/package_upload', 'LinkController@uploadFiles');

Route::post('/add_site', 'SiteController@addSite');
Route::post('/delete_site', 'SiteController@deleteSite');

Route::get('/report', 'ReportController@index');
Route::post('/report', 'ReportController@makeReport')->name('make_report');

