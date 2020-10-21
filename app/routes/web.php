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
Route::get('/blogs', 'FsnsController@blogs')->middleware('auth');
Route::get('/team/{id}', 'FsnsController@team')->middleware('auth');
Route::get('/teams', 'FsnsController@teams')->middleware('auth');
Route::get('/create', 'FsnsController@create')->middleware('auth');
Route::get('/update/login/{id}', 'FsnsController@teamlogin')->middleware('auth');
Route::post('/update/{id}', 'FsnsController@change');
Route::get('/myPage/{id}', 'FsnsController@mypage')->middleware('auth');
Route::get('/players', 'FsnsController@players')->middleware('auth');
Route::get('/player', 'FsnsController@player')->middleware('auth');

Route::get('/team/{id}/days', 'FsnsController@days')->middleware('auth');
Route::get('/team/{id}/days/todo', 'FsnsController@todo')->middleware('auth');
Route::get('/team/{id}/days/daysUp/{todo_id}', 'FsnsController@daysup')->middleware('auth');
Route::get('/team/{id}/movie', 'FsnsController@movie')->middleware('auth');
Route::get('/team/{id}/movie/movieup/{movie_id}', 'FsnsController@movieup')->middleware('auth');
Route::get('/team/{id}/movie/upload', 'FsnsController@upload')->middleware('auth');
Route::get('/team/{id}/blog', 'FsnsController@blog')->middleware('auth');
Route::get('/team/{id}/blog/blogup/{blog_id}', 'FsnsController@blogup')->middleware('auth');
Route::get('/team/{id}/blog/post', 'FsnsController@post')->middleware('auth');
Route::get('/team/{id}/contact', 'FsnsController@contact')->middleware('auth');
Route::get('/team/{id}/follower', 'FsnsController@follower')->middleware('auth');
Route::get('/followTeams/{id}', 'FsnsController@followteams')->middleware('auth');

Route::post('/delete/{id}', 'FsnsController@del');
Route::post('/serch','FsnsController@serch');
Route::post('/teams', 'FsnsController@edit');
Route::post('/team/{id}', 'FsnsController@update');
Route::post('/team/{id}/days', 'FsnsController@add');
Route::post('/team/{id}/days/todo', 'FsnsController@dup');
Route::post('/team/{id}/days/{todo_id}/delete', 'FsnsController@ddel');
Route::post('/team/{id}/blog', 'FsnsController@show');
Route::post('/team/{id}/movie', 'FsnsController@up');
Route::post('/team/{id}/movie/mup/{movie_id}', 'FsnsController@mup');
Route::post('/team/{id}/movie/mdel/{movie_id}', 'FsnsController@mdel');
Route::post('/team/{id}/blog/bup/{blog_id}', 'FsnsController@bup');
Route::post('/team/{id}/blog/bdel/{blog_id}', 'FsnsController@bdel');
Route::post('/team/{id}/contact', 'FsnsController@mail');
Route::post('/team/{id}/follower', 'FsnsController@tfollow');
Route::post('/players', 'FsnsController@user');
Route::post('/myPage/{id}', 'FsnsController@rewrite');
Route::post('/myPage/{id}/account', 'FsnsController@account');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
