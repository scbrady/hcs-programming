<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index');
Route::get('settings', ['as' => 'settings', 'uses' => 'UserController@settings']);
Route::post('settings/update', 'UserController@updateMe');
Route::post('settings/change-password', 'UserController@changePassword');

Route::get('programs', 'AssignmentController@index');
Route::get('programs/create', 'AssignmentController@create');
Route::post('programs/store', 'AssignmentController@store');
Route::get('programs/{id}', 'AssignmentController@show');
Route::post('programs/{id}/upload', 'AssignmentController@upload');