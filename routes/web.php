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
    Route::resource('lists', 'TaskListController')->except(['index', 'create', 'edit', 'show', 'destroy']);
    Route::resource('tasks', 'TaskController')->except(['index', 'create', 'edit', 'show']);
    Route::get('/archive', 'TaskListController@archive')->name('archive');
    Route::get('/deleted', 'TaskListController@deleted')->name('deleted');
    Route::get('/export/{id}', 'TaskListController@exportTasks')->name('export');
});

Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function (){
    Route::get('/', 'Admin\UserController@index')->name('home');
    Route::get('/delete_requests', 'Admin\DeleteRequestsController@index')->name('delete-requests');
    Route::post('/destroy/{id}', 'Admin\DeleteRequestsController@destroy')->name('destroy');
    Route::resource('users', 'Admin\UserController')->only(['index', 'show']);
});

Auth::routes();