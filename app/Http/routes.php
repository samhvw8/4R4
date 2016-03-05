<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});


/**
 * Get all users
 */
Route::get('api/v1/users', [
    'as' => 'user.all',
    'uses' => 'Api\v1\UsersController@all'
]);

/**
 * Create a new user
 */
Route::post('api/v1/user', [
    'as' => 'user.create',
    'uses' => 'Api\v1\UsersController@create'
]);


/**
 * Get user info by id
 */
Route::get('api/v1/user/{id}', [
    'as' => 'user.get',
    'uses' => 'Api\v1\UsersController@get'
]);

/**
 * Update user info
 */

/**
 * Delete user
 */
