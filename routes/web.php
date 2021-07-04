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

Route::get('/readme', 'HomeController@readme');

Route::get('/users/profile/{id}', 'UserController@profile');
Route::get('/users/edit/prof_edit', 'UserController@profEdit');
Route::post('/users/update/prof', 'UserController@profUpdate');
Route::get('/users/edit/follow_edit', 'UserController@followEdit');
Route::post('/users/follow/{id}', 'UserController@follow');

Route::get('/users/follow_list', 'UserController@follow_list');

Route::get('/works/add/novel', 'WorkController@addNovel');
Route::post('/works/store/novel', 'WorkController@storeNovel');

Route::get('/works/add/illust', 'WorkController@addIllust');
Route::post('/works/store/illust', 'WorkController@storeIllust');

Route::get('/works/add/end', 'WorkController@addEnd');
Route::get('/works/index', 'WorkController@index');//作品管理画面（一覧）
Route::get('/works/detail/{id}', 'WorkController@detail');//作品詳細画面

Route::post('/works/password_check', 'WorkController@password_check');//パスワード付き作品の内容表示

Route::get('/works/edit/novel/{id}', 'WorkController@editNovel');//小説作品編集画面
Route::get('/works/edit/illust/{id}', 'WorkController@editIllust');//イラスト作品編集画面
Route::post('/works/update/novel/{id}', 'WorkController@updateNovel');//小説作品編集保存
Route::post('/works/update/illust/{id}', 'WorkController@updateIllust');//イラスト作品編集保存

Route::get('/search', 'WorkController@search');//作品検索

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});