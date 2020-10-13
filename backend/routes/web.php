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

Route::get('/', 'PostController@index')->name('home');

Auth::routes();

//ゲストログイン
Route::post('/guest', 'Auth\LoginController@guest');

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/mypage', 'UserController@index');

    Route::get('/mypage/edit', 'UserController@edit');

    Route::post('/mypage/update', 'UserController@update');

    Route::post('/create', 'PostController@create');
    
    Route::post('/delete/{id}', 'PostController@delete');

    Route::post('/getid', 'PostController@getid');

    Route::post('/edit', 'PostController@edit');

    Route::post('/favorite/attach', 'PostController@attach');

    Route::post('/favorite/detach', 'PostController@detach');

    Route::get('/post/{id}', 'TalkController@index');

    Route::post('/talk/create', 'TalkController@create');

    Route::post('/talk/delete/{id}', 'TalkController@delete');

    Route::get('/search', 'PostController@search');

    Route::post('/mypage/getdata', 'UserController@getData');

    Route::post('/mypage/getdata2week', 'UserController@getData2week');

    Route::get('/userpage/{id}', 'UserController@other');
});