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

Route::get('/', 'TaskListController@index')->name('home');

Route::middleware('role:user')->group(function (){
    Route::resource('lists', 'TaskListController')->except(['index', 'create', 'edit', 'show']);
    Route::resource('tasks', 'TaskController')->except(['index', 'create', 'edit', 'show']);
});

Auth::routes();