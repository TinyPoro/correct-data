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

Route::get('/post/{postId}/edit', 'WebController@editPost');

Route::get('/post/create', 'WebController@createPost');

Route::get('/post/{postId}/raw', 'WebController@rawHistory');

Route::put('/api/post/{postId}', 'WebController@editPostApi')->name('edit.post');

Route::post('/api/post', 'WebController@createPostApi')->name('create.post');

Route::get('/api/test', 'WebController@test');


//test

Route::get('/post1/{postId}/edit', 'WebController1@editPost');

Route::get('/post1/create', 'WebController1@createPost');

Route::get('/post1/{postId}/raw', 'WebController1@rawHistory');

Route::put('/api/post1/{postId}', 'WebController1@editPostApi')->name('edit.post1');

Route::post('/api/post1', 'WebController1@createPostApi')->name('create.post1');