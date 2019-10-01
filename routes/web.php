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
Route::get('projects/search', 'ProjectController@doSearch');
Route::post('projects', 'ProjectController@doCreateProject');
Route::get('projects/create', 'ProjectController@showCreateProjectPage');
Route::get('projects/{project}/edit', 'ProjectController@showEditProjectPage');
Route::put('projects/{project}', 'ProjectController@doEditProject');
Route::get('projects/{project}/preview', 'ProjectController@preview');
Route::delete('projects/{project}', 'ProjectController@doDeleteProject');

Route::get('profile', 'ProfileController@showProfilePage');
Route::put('profile', 'ProfileController@doUpdateProfile');

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
    Route::get('advisers/{adviserId}/delete', 'AdviserController@doDeleteAdviser');

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
     Route::get('areas/{areaId}/delete', 'AreaController@doDeleteArea');

});



/** ROUTES FOR STUDENTS */

Route::group(['namespace' => 'User'], function () {
    Route::get('my-projects', 'MyProjectsController');
});


/** ROUTES FOR ADVIDERS */

Route::group(['namespace' => 'Adviser'], function () {
    Route::get('my-handled-projects', 'HandledProjectsController@index');
    Route::get('my-handled-projects/{project}', 'HandledProjectsController@show');
    Route::put('my-handled-projects/{project}', 'HandledProjectsController@update');
});
