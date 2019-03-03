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


/**
 * ADMIN ROUTES
 */

Route::group(['namespace' => 'Admin'], function () {
     // list all advisers
    Route::get('advisers', 'AdviserController@showAdvisersListPage');
    // show edit adviser page
    Route::get('advisers/{adviserId}/edit', 'AdviserController@showAdvisersListPage');
    // show create adviser page
    Route::get('advisers/create', 'AdviserController@showCreateAdviserPage');
    // create new adviser
    Route::post('advisers', 'AdviserController@doCreateAdviser');

     // list all advisers
     Route::get('areas', 'AreaController@showAreasListPage');
     // show edit adviser page
     Route::get('areas/{areaId}/edit', 'AreaController@showEditAreaPage');
     // show create adviser page
     Route::get('areas/create', 'AreaController@showCreateAreaPage');
     // create new adviser
     Route::post('areas', 'AreaController@doCreateArea');
});