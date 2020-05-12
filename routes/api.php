<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/user', 'UserController@index');
Route::post('/user/add', 'UserController@add');
Route::get('user/all', 'UserController@all');
Route::get('user/profile', 'UserController@profile');
Route::post('user/edit', 'UserController@update');
Route::delete('user/delete', 'UserController@destroy');
