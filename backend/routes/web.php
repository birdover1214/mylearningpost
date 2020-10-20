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
Route::post('/guest', 'Auth\LoginController@guest')->name('guest');

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/mypage', 'UserController@index')->name('mypage');

    Route::get('/mypage/edit', 'UserController@edit')->name('mypage.edit');

    Route::post('/mypage/update', 'UserController@update')->name('mypage.update');

    Route::post('/mypage/delete', 'UserController@delete')->name('user.delete');

    Route::post('/create', 'PostController@create')->name('post.create');
    
    Route::post('/delete/{id}', 'PostController@delete')->name('post.delete');

    Route::post('/getid', 'PostController@getid')->name('post.getid');

    Route::post('/edit', 'PostController@edit')->name('post.edit');

    Route::post('/favorite/attach', 'PostController@attach')->name('post.attach');

    Route::post('/favorite/detach', 'PostController@detach')->name('post.detach');

    Route::get('/post/{id}', 'TalkController@index')->name('talk');

    Route::post('/talk/create', 'TalkController@create')->name('talk.create');

    Route::post('/talk/delete/{id}', 'TalkController@delete')->name('talk.delete');

    Route::get('/search', 'PostController@search')->name('search');

    Route::post('/mypage/getdata', 'UserController@getData')->name('mypage.getdata');

    Route::get('/userpage/{id}', 'UserController@other')->name('userpage');
});