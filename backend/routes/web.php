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

//Auth::routes();

Route::group(['prefix' => 'user', 'namespace' => 'User'], function() {

    Route::get('/home', 'HomeController@index')->name('user.home');

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('user.login');

    Route::post('login', 'Auth\LoginController@login');

    Route::post('logout', 'Auth\LoginController@logout')->name('user.logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('user.register');

    Route::post('register', 'Auth\RegisterController@register');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');

    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('user.password.reset');

    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    //ゲストログイン
    Route::post('guest', 'Auth\LoginController@guest')->name('guest');

});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

    Route::get('/home', 'HomeController@index')->name('admin.home');

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');

    Route::post('login', 'Auth\LoginController@login');

    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');

    Route::post('register', 'Auth\RegisterController@register');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');

    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {

    Route::get('/post', 'AdminController@post')->name('admin.post');    

    Route::get('/post/search', 'AdminController@postSearch')->name('admin.post.search');

    Route::post('/post/delete/{id}', 'AdminController@postDelete')->name('admin.post.delete');

    Route::get('/comment', 'AdminController@comment')->name('admin.comment');

    Route::get('/comment/search', 'AdminController@commentSearch')->name('admin.comment.search');

    Route::post('/comment/delete/{id}', 'AdminController@commentDelete')->name('admin.comment.delete');

    Route::get('/user', 'AdminController@user')->name('admin.user');

    Route::get('/user/search', 'AdminController@userSearch')->name('admin.user.search');

    Route::post('/user/delete/{id}', 'AdminController@userDelete')->name('admin.user.delete');

    Route::get('/skill', 'AdminController@skill')->name('admin.skill');

    Route::get('/skill/search', 'AdminController@skillSearch')->name('admin.skill.search');

    Route::post('/skill/delete/{id}', 'AdminController@skillDelete')->name('admin.skill.delete');

    Route::post('/skill/add', 'AdminController@skillAdd')->name('admin.skill.add');

    Route::get('/edit', 'AdminController@edit')->name('admin.edit');

    Route::post('/update', 'AdminController@update')->name('admin.update');

    Route::post('/delete', 'AdminController@delete')->name('admin.delete');
});


Route::group(['middleware' => 'auth'], function() {

    Route::get('user/mypage', 'UserController@index')->name('mypage');

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
