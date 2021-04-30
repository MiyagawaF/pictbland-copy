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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/{id}', 'UserController@profile');
Route::get('/users/edit/prof_edit', 'UserController@profEdit');
Route::get('/users/edit/follow_edit', 'UserController@followEdit');

Route::get('/works/add/novel', 'WorkController@addNovel');
Route::post('/works/store/novel', 'WorkController@storeNovel');
Route::get('/works/add/end', 'WorkController@addEnd');
Route::get('/works/{id}', 'WorkController@addEnd');

Route::get('/works/detail/list', 'WorkController@list');
Route::get('/works/detail/{id}', 'WorkController@detail');

Auth::routes();