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

Route::get('/', 'TodoController@index')->name('todo.index');
Route::post('/store', 'TodoController@store')->name('todo.store');
Route::post('/update/{id}', 'TodoController@update')->name('todo.update');
Route::get('/delete/{id}', 'TodoController@delete')->name('todo.delete');
Route::get('/status/{id1}/{id2}', 'TodoController@status')->name('todo.status');
Route::get('/clear/completed', 'TodoController@clear')->name('todo.clear');
Route::get('/show/all', 'TodoController@showAll')->name('todo.showAll');
Route::get('/show/active', 'TodoController@showActive')->name('todo.showActive');
Route::get('/show/completed', 'TodoController@showCompleted')->name('todo.showCompleted');