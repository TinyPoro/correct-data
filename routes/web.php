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

Route::get('/', 'WebController@index');

Route::get('/post/edit/{postId}', 'WebController@editPost');

Route::get('/post/create', 'WebController@createPost');

Route::get('/post/{postId}/raw', 'WebController@rawHistory');

Route::put('/api/post/{postId}', 'WebController@editPostApi')->name('edit.post');

Route::post('/api/post', 'WebController@createPostApi')->name('create.post');

Route::get('/api/test', 'WebController@test');