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

Route::get('/users/profile/{id}', 'UserController@profile');
Route::get('/users/edit/prof_edit', 'UserController@profEdit');
Route::get('/users/edit/follow_edit', 'UserController@followEdit');

Route::get('/works/add/novel', 'WorkController@addNovel');
Route::post('/works/store/novel', 'WorkController@storeNovel');
Route::get('/works/add/end', 'WorkController@addEnd');
// Route::get('/works/{id}', 'WorkController@addEnd');
Route::get('/works/index', 'WorkController@index');//作品管理画面（一覧）
Route::get('/works/detail/{id}', 'WorkController@detail');//作品詳細画面
Route::get('/works/edit/novel/{id}', 'WorkController@editNovel');//小説作品編集画面
Route::post('/works/update/novel/{id}', 'WorkController@updateNovel');//小説作品編集保存

Auth::routes();