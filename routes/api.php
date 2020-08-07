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
Route::post('/user/addauditors', 'UserController@addauditors');
Route::get('user/all', 'UserController@all');
Route::get('user/profile', 'UserController@profile');
Route::post('user/edit', 'UserController@update');
Route::delete('user/delete', 'UserController@destroy');
Route::post('user/verification', 'UserController@verification');

//login
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@main');


Route::get('unauthorized', ['as' => 'unauthorized', 'uses' => 'LoginController@unauthorized']);

Route::post('/project/setupteam', 'ProjectController@addSetupTeam');
Route::get('project/all', 'ProjectController@all');
Route::get('project/details', 'ProjectController@details');
Route::get('project/bycompany', 'ProjectController@projectbycompany');
Route::delete('project/delete', 'ProjectController@destroy');
Route::post('project/addinformation', 'ProjectController@information');
Route::get('/project/viewinformation', 'ProjectController@viewinformation');
Route::post('project/edit', 'ProjectController@update');
Route::post('project/addgeneralinformation', 'ProjectController@generalinformation');
Route::get('project/viewgeneralinformation', 'ProjectController@viewgeneralinformation');
Route::post('project/addoperationinformation', 'ProjectController@operationinformation');
Route::get('project/viewoperationinformation', 'ProjectController@viewoperationinformation');
Route::post('project/addenergymanagementreview', 'ProjectController@managementreview');
Route::get('project/viewenergymanagementreview', 'ProjectController@viewmanamgentreview');
Route::post('project/energygeneralinformation', 'ProjectController@energygeneralinformation');
Route::post('project/energytariffstructure', 'ProjectController@energytariffstructure');
Route::post('project/energytarifftimezone', 'ProjectController@energytarifftimezone');
Route::post('project/lightingregistry', 'ProjectController@lightingregistry');
Route::post('/project/addproject','ProjectController@addproject');
Route::post('/project/references', 'ProjectController@references');
Route::post('/project/singleline','ProjectController@singleline');

//team
Route::get('/team', 'TeamController@index');
Route::get('/team/teambyproject', 'TeamController@teambyproject');
Route::get('/team/detailsteam', 'TeamController@detailsteam');
Route::post('/team/updateteam', 'TeamController@updateteam');
Route::delete('/team/delete', 'TeamController@destroy');


//token
Route::group(['middleware' => ['auth:api','token']], function(){

//project
Route::get('/project', 'ProjectController@index');
   

//staff
Route::get('/staff/company', 'UserController@listofstaff');
Route::get('/staff/listuserrole', 'UserController@listuserrole');

//Role
Route::get('/role', 'RoleController@index');
Route::get('/role/all', 'RoleController@all');    

});