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
Route::get('/update/{id}', 'FsnsController@change');

Route::get('/team/{id}/days', 'FsnsController@days');
Route::get('/team/{id}/movie', 'FsnsController@movie');
Route::get('/team/{id}/blog', 'FsnsController@blog');
Route::get('/team/{id}/contact', 'FsnsController@contact');

Route::post('/teams', 'FsnsController@edit');
Route::post('/team/{id}', 'FsnsController@update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
