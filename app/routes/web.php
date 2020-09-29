<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'FsnsController@index');
Route::get('/team/{id}', 'FsnsController@team');
Route::get('/teams', 'FsnsController@teams');
Route::get('/create', 'FsnsController@create');
Route::get('/update', 'FsnsController@update');
Route::post('/teams', 'FsnsController@edit');
// Route::get('/team', 'FsnsController@days');
// Route::get('/days', 'FsnsController@days');
// Route::get('/movies', 'FsnsController@movies');
// Route::get('/blog', 'FsnsController@blogs');
// Route::get('/contact', 'FsnsController@contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
