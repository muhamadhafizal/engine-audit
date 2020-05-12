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

//user management
Route::get('/user', 'UserController@index');
Route::post('/user/add', 'UserController@add');
Route::get('user/all', 'UserController@all');
Route::get('user/profile', 'UserController@profile');
Route::post('user/edit', 'UserController@update');
Route::delete('user/delete', 'UserController@destroy');

//login
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@main');

Route::get('unauthorized', ['as' => 'unauthorized', 'uses' => 'LoginController@unauthorized']);

//token
Route::group(['middleware' => ['auth:api','token']], function(){

    //project
    Route::get('/project', 'ProjectController@index');

    //staff
    Route::get('/staff/company', 'UserController@listofstaff');

    //Role
    Route::get('/role', 'RoleController@index');
    Route::get('/role/all', 'RoleController@all');    

});