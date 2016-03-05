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


Route::group([['prefix' => 'api/v1']], function() {

    /**
     * Get all users
     */
    Route::get('users', [
        'as' => 'user.all',
        'uses' => 'Api\v1\UsersController@all'
    ]);

    /**
     * Create a new user
     */
    Route::post('user', [
        'as' => 'user.create',
        'uses' => 'Api\v1\UsersController@create'
    ]);


    /**
     * Get user info by id
     */
    Route::get('user/{id}', [
        'as' => 'user.get',
        'uses' => 'Api\v1\UsersController@get'
    ]);

    /**
     * Update user info
     */


    /**
     * Delete user
     */

//    =============================================================

    /**
     * Get all rooms
     */
    Route::get('rooms', [
        'as' => 'room.all',
        'uses' => 'Api\v1\RoomsController@all'
    ]);

    /**
     * Create a new room
     */
    Route::post('room', [
        'as' => 'room.create',
        'uses' => 'Api\v1\RoomsController@create'
    ]);


    /**
     * Get room info by id
     */
    Route::get('room/{id}', [
        'as' => 'room.get',
        'uses' => 'Api\v1\RoomsController@get'
    ]);

    /**
     * Update room  info
     */


    /**
     * Delete room
     */


    /**
     * group search room
     */
    Route::group([['prefix' => 'room/search']],function () {
        Route::post('near', [
            'as' => 'room.searchNear',
            'uses' => 'Api\v1\RoomsController@searchNear'
        ]);

    });
});