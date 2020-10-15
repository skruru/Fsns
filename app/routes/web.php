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
Route::get('/myPage/{id}', 'FsnsController@mypage');
Route::get('/myPage/{id}/account', 'FsnsController@account');
Route::get('/players', 'FsnsController@players');
Route::get('/player', 'FsnsController@player');

Route::get('/team/{id}/days', 'FsnsController@days');
Route::get('/team/{id}/days/todo', 'FsnsController@todo');
Route::get('/team/{id}/movie', 'FsnsController@movie');
Route::get('/team/{id}/movie/upload', 'FsnsController@upload');
Route::get('/team/{id}/blog', 'FsnsController@blog');
Route::get('/team/{id}/blog/post', 'FsnsController@post');
Route::get('/team/{id}/contact', 'FsnsController@contact');

Route::post('/delete/{id}', 'FsnsController@del');
Route::post('/serch','FsnsController@serch');
Route::post('/teams', 'FsnsController@edit');
Route::post('/team/{id}', 'FsnsController@update');
Route::post('/team/{id}/days', 'FsnsController@add');
Route::post('/team/{id}/blog', 'FsnsController@show');
Route::post('/team/{id}/movie', 'FsnsController@up');
Route::post('/team/{id}/contact', 'FsnsController@mail');
Route::post('/players', 'FsnsController@user');
Route::post('/myPage/{id}', 'FsnsController@rewrite');

Route::get('/team/{id}/days/dayschan', 'FsnsController@dayschan');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
