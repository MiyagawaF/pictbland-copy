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

Route::get('/works/add/novel', 'WorkController@addNovel');
Route::post('/works/store/novel', 'WorkController@storeNovel');

Route::get('/works/{id}', 'WorkController@detail');

Auth::routes();