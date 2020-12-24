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


Route::post('/project/addproject','ProjectController@addproject');
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
Route::get('project/viewenergygeneralinformation', 'ProjectController@viewenergygeneralinformation');
Route::post('project/energytariffstructure', 'ProjectController@energytariffstructure');
Route::get('project/viewenergytariffstructure', 'ProjectController@viewenergytariffstructure');
// Route::post('project/energytarifftimezone', 'ProjectController@energytarifftimezone');
// Route::post('project/lightingregistry', 'ProjectController@lightingregistry');
Route::post('/project/references', 'ProjectController@references');
Route::get('/project/viewreference', 'ProjectController@viewreference');
Route::post('/project/registerroom', 'ProjectController@registerroom');
Route::get('/project/listroom', 'ProjectController@listroom');
Route::delete('/project/deleteroom', 'ProjectController@deleteroom');
Route::post('/project/editroom', 'ProjectController@editroom');
Route::post('/project/addsingleline','ProjectController@singleline');
Route::get('/project/listsingleline', 'ProjectController@listsingleline');
Route::post('/project/editsingleline', 'ProjectController@editsingleline');
Route::delete('/project/deletesingleline', 'ProjectController@deletesingleline');

//team
Route::get('/team', 'TeamController@index');
Route::get('/team/teambyproject', 'TeamController@teambyproject');
Route::get('/team/detailsteam', 'TeamController@detailsteam');
Route::post('/team/updateteam', 'TeamController@updateteam');
Route::delete('/team/delete', 'TeamController@destroy');

//project
Route::get('/project', 'ProjectController@index');
   

//staff
Route::get('/staff/company', 'UserController@listofstaff');
Route::get('/staff/listuserrole', 'UserController@listuserrole');

//Role
Route::get('/role', 'RoleController@index');
Route::get('/role/all', 'RoleController@all');    

//Equipments
Route::post('/equipments/addequipment', 'EquipmentController@addequipment');
Route::get('/equipments/listequipment', 'EquipmentController@listequipment');
Route::post('/equipments/updateequipment', 'EquipmentController@updateequipment');
Route::delete('equipments/deleteequipment', 'EquipmentController@deleteequipment');
Route::post('/equipments/addsetup', 'EquipmentController@addsetup');
Route::get('/equipments/listsetup', 'EquipmentController@listsetup');
Route::get('/equipments/detailssetup', 'EquipmentController@detailssetup');
Route::delete('/equipments/deletesetup', 'EquipmentController@destroysetup');
Route::post('/equipments/editsetup', 'EquipmentController@editsetup');

//Energysourcecateogry
Route::get('/energysource','EnergysourceController@index');
Route::get('/energysource/all', 'EnergysourceController@all');
Route::get('/energysource/details', 'EnergysourceController@details');

//Permission
Route::get('/permission', 'PermissionController@index');
Route::post('/permission/add', 'PermissionController@store');
Route::delete('/permission/delete', 'PermissionController@destroy');
Route::get('/permission/all', 'PermissionController@all');
Route::get('/permission/details', 'PermissionController@details');

//Form
Route::get('/form', 'FormController@index');
Route::post('/form/generatemasterform', 'FormController@store');
Route::get('/form/detailsmasterform', 'FormController@details');
Route::post('/form/savemasterform', 'FormController@save');
Route::post('/form/subequipment', 'FormController@subequipment');
Route::post('/form/savesubform', 'FormController@savesubequipment');
Route::post('/form/generatedependentform', 'FormController@generatedependentform');
Route::get('/form/listdependent', 'FormController@listdependent');
Route::post('/form/generatedependentsub', 'FormController@generatedependentsub');
Route::get('/form/detailsdependent', 'FormController@detailsdependent');
Route::get('/form/listsubinventorybyform', 'FormController@listsubequipment');
Route::delete('/form/deletesubinventory', 'FormController@deletesubinventory');
Route::get('/form/addsubinventory', 'FormController@addsubinventory');

//Mainicomings
Route::get('/mainincoming', 'MainincomingController@index');
Route::post('/mainincoming/store', 'MainincomingController@store');
//Route::get('/mainincoming/list', 'MainincomingController@all');
Route::post('/mainincoming/edit', 'MainincomingController@update');
Route::get('/mainincoming/listname', 'MainincomingController@listmainincoming');
Route::get('/mainincoming/details', 'MainincomingController@details');
Route::get('/mainincoming/submeter', 'MainincomingController@submeter');

//Submeter
Route::get('/submeter', 'SubmeterController@index');
Route::post('/submeter/store', 'SubmeterController@store');
Route::get('/submeter/list', 'SubmeterController@list');


//Database
Route::get('/database', 'DatabaseController@index');
Route::get('/database/logging/all', 'DatabaseController@alllogging');
Route::get('/database/logging/details', 'DatabaseController@detailslogging');
Route::get('/database/typeoflight/all', 'DatabaseController@alltypeoflight');
Route::get('/database/typeoflight/details', 'DatabaseController@detailstypeoflight');
Route::get('/database/lightingcontrol/all', 'DatabaseController@alllightingcontroll');
Route::get('/database/lightingcontrol/details', 'DatabaseController@detailslightingcontrol');
Route::get('/database/airconditioning/all', 'DatabaseController@allairconditioning');
Route::get('/database/airconditioning/details', 'DatabaseController@detailsairconditioning');
Route::get('/database/lighting/all', 'DatabaseController@alllighting');
Route::get('/database/lighting/details','DatabaseController@detailslighting');

//Lightdeviation
Route::get('/lightdeviation', 'LightdeviationController@index');
Route::get('/lightdeviation/generate', 'LightdeviationController@generate');
Route::post('/lightdeviation/save', 'LightdeviationController@save');
Route::get('/lightdeviation/details', 'LightdeviationController@details');

//Capactity
Route::get('/capacity', 'CapacityController@index');
Route::get('/capacity/generate','CapacityController@generate');

//Analysis
Route::get('/analysis', 'AnalysisController@index');
Route::get('/analysis/installedlighting', 'AnalysisController@installedlighting');
Route::get('/analysis/energyconsumption', 'AnalysisController@energyconsumption');
Route::get('/analysis/energycost', 'AnalysisController@energycost');

//Generate
Route::get('/generate', 'GenerateController@index');
Route::post('/generate/add', 'GenerateController@store');
Route::get('/generate/list', 'GenerateController@list');
Route::post('/generate/edit', 'GenerateController@edit');
Route::get('/generate/delete', 'GenerateController@destroy');

Route::get('unauthorized', ['as' => 'unauthorized', 'uses' => 'LoginController@unauthorized']);
//token
Route::group(['middleware' => ['auth:api','token']], function(){


});