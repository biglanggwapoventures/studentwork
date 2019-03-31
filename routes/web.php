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

Route::get('/', 'HomeController@index');
Route::get('view/{projectId}', 'HomeController@viewProject');

Route::get('register', 'RegistrationController@showRegistrationPage');
Route::post('register', 'RegistrationController@doRegister');

Route::get('login', 'LoginController@showLoginPage');
Route::post('login', 'LoginController@doLogin');

Route::get('logout', 'LogoutController@doLogout');

Route::get('projects', 'ProjectController@showProjectsListPage');
Route::post('projects', 'ProjectController@doCreateProject');
Route::get('projects/create', 'ProjectController@showCreateProjectPage');

Route::get('projects/pdf', 'ProjectController@showPdf');

/**
 * ADMIN ROUTES
 */

Route::group(['namespace' => 'Admin'], function () {
     
     // ADVISERS
     // list all advisers
    Route::get('advisers', 'AdviserController@showAdvisersListPage');
    // show create adviser page
    Route::get('advisers/create', 'AdviserController@showCreateAdviserPage');
    // show edit adviser page
    Route::get('advisers/{adviserId}/edit', 'AdviserController@showEditAdviserPage');
    
    // create new adviser
    Route::post('advisers', 'AdviserController@doCreateAdviser');
    // update new adviser
    Route::post('advisers/{adviserId}/update', 'AdviserController@doUpdateAdviser');
    // delete new adviser
    Route::delete('advisers/{adviserId}/delete', 'AdviserController@doDeleteAdviser');

     // AREAS
     // list all areas
     Route::get('areas', 'AreaController@showAreasListPage');
     // show create area page
     Route::get('areas/create', 'AreaController@showCreateAreaPage');
     // show edit area page
     Route::get('areas/{areaId}/edit', 'AreaController@showEditAreaPage');

     // create new area
     Route::post('areas', 'AreaController@doCreateArea');
     // update area
     Route::post('areas/{areaId}/update', 'AreaController@doUpdateArea');
     // delete area
     Route::delete('areas/{areaId}/delete', 'AreaController@doDeleteArea');

});
