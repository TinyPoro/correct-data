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

Route::get('/login', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', '\App\Http\Controllers\Auth\LoginController@login');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'ToolController@index');

// sửa
    Route::get('/post/{postId}/edit', 'ToolController@editPost')->name('post.edit');
    Route::get('/raw_history/{postId}', 'ToolController@rawHistory')->name('raw_history');;
    Route::post('/post/{postId}', 'ToolController@updatePost')->name('post.update');

//gán nhãn
    Route::get('/post/{postId}/label', 'ToolController@editLabelPost')->name('post.edit_label');
    Route::post('/post_label/{postId}', 'ToolController@updateLabelPost')->name('post.update_label');

//tạo mới
    Route::get('/post/create', 'ToolController@createPost')->name('post.create');;
    Route::post('/post', 'ToolController@storePost')->name('post.store');
});