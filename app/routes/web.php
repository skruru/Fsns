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

//--------------------------------------top---------------------------------------
Route::get('/', 'FsnsController@index');
Route::get('/blogs', 'FsnsController@blogs')->middleware('auth');

//--------------------------------------teams---------------------------------------
Route::get('/teams', 'FsnsController@teams')->middleware('auth');
Route::post('/serch','FsnsController@serch');

Route::get('/create', 'FsnsController@create')->middleware('auth');
Route::post('/teams', 'FsnsController@edit');

//--------------------------------------team---------------------------------------
Route::get('/team/{id}', 'FsnsController@team')->middleware('auth');
Route::get('/team/login/{id}', 'FsnsController@teamlogin')->middleware('auth');
Route::get('/team/{id}/follower', 'FsnsController@follower')->middleware('auth');

Route::post('/team/{id}', 'FsnsController@teamleader');
Route::post('/team/login/{id}', 'FsnsController@update');
Route::post('/delete/{id}', 'FsnsController@del');
Route::post('/team/{id}/follower', 'FsnsController@tfollow');

//--------------------------------------days---------------------------------------
Route::get('/team/{id}/days', 'FsnsController@days')->middleware('auth');
Route::get('/team/{id}/days/todo', 'FsnsController@todo')->middleware('auth');
Route::get('/team/{id}/days/daysUp/{todo_id}', 'FsnsController@daysup')->middleware('auth');

Route::post('/team/{id}/days', 'FsnsController@add');
Route::post('/team/{id}/days/todo', 'FsnsController@dup');
Route::post('/team/{id}/days/{todo_id}/delete', 'FsnsController@ddel');

//--------------------------------------movie---------------------------------------
Route::get('/team/{id}/movie', 'FsnsController@movie')->middleware('auth');
Route::get('/team/{id}/movie/upload', 'FsnsController@upload')->middleware('auth');
Route::get('/team/{id}/movie/movieup/{movie_id}', 'FsnsController@movieup')->middleware('auth');

Route::post('/team/{id}/movie', 'FsnsController@up');
Route::post('/team/{id}/movie/mup/{movie_id}', 'FsnsController@mup');
Route::post('/team/{id}/movie/mdel/{movie_id}', 'FsnsController@mdel');

//--------------------------------------blog---------------------------------------
Route::get('/team/{id}/blog', 'FsnsController@blog')->middleware('auth');
Route::get('/team/{id}/blog/post', 'FsnsController@post')->middleware('auth');
Route::get('/team/{id}/blog/blogup/{blog_id}', 'FsnsController@blogup')->middleware('auth');

Route::post('/team/{id}/blog', 'FsnsController@show');
Route::post('/team/{id}/blog/bup/{blog_id}', 'FsnsController@bup');
Route::post('/team/{id}/blog/bdel/{blog_id}', 'FsnsController@bdel');

//--------------------------------------contact---------------------------------------
Route::get('/team/{id}/contact', 'FsnsController@contact')->middleware('auth');
Route::post('/team/{id}/contact', 'FsnsController@mail');

//--------------------------------------myPage---------------------------------------

Route::get('/myPage/{id}', 'FsnsController@mypage')->middleware('auth');
Route::get('/followTeams/{id}', 'FsnsController@followteams')->middleware('auth');
Route::post('/myPage/{id}/account', 'FsnsController@account');
Route::post('/myPage/{id}', 'FsnsController@rewrite');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
