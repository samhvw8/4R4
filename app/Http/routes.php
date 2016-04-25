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

Route::group(['prefix' => 'api/v1'], function () {


    Route::group(['middleware' => 'auth.basic'], function () {
        //    ====================== User ================================

        /**
         * Login User
         */
        Route::get('login',[
            'as' => 'user.login',
            'uses' => 'Api\v1\UsersController@login'
        ]);

        /**
         * Get all users
         */

        Route::get('users', [
            'as' => 'user.all',
            'uses' => 'Api\v1\UsersController@all'
        ]);



        /**
         * Update user info
         */
        Route::put('user/{id}', [
            'as' => 'user.update',
            'uses' => 'Api\v1\UsersController@update'
        ]);

        /**
         * Delete user
         */
        Route::delete('user/{id}', [
            'as' => 'user.delete',
            'uses' => 'Api\v1\UsersController@delete'
        ]);

        /**
         * Get user's rooms by id
         */

        Route::get('user/{id}/rooms', [
            'as' => 'user.getRoom',
            'uses' => 'Api\v1\UsersController@getRoom'
        ]);


        Route::group(['middleware' => 'r4r\Http\Middleware\AdminCheck'], function () {
            /**
             * Get all admins
             */

            Route::get('admins', [
                'as' => 'user.allAdmin',
                'uses' => 'Api\v1\UsersController@allAdmin'
            ]);
            /**
             * Make user admin
             */

            Route::get('user/{id}/admin', [
                'as' => 'user.makeAdmin',
                'uses' => 'Api\v1\UsersController@makeAdmin'
            ]);

            /**
             * Delete admin
             */
            Route::get('user/{id}/deladmin', [
                'as' => 'user.delAdmin',
                'uses' => 'Api\v1\UsersController@delAdmin'
            ]);


            Route::get('room_update_address', [
                'as' => 'room.update_address',
                'uses' => 'Api\v1\RoomsController@updateAdress'
            ]);

        });

//    ====================== Room ================================

        /**
         * Create a new room
         */
        Route::post('room', [
            'as' => 'room.create',
            'uses' => 'Api\v1\RoomsController@create'
        ]);

        /**
         * Update room  info
         */
        Route::put('room/{id}', [
            'as' => 'room.update',
            'uses' => 'Api\v1\RoomsController@update'
        ]);

        /**
         * Delete room
         */
        Route::delete('room/{id}', [
            'as' => 'room.delete',
            'uses' => 'Api\v1\RoomsController@delete'
        ]);

    });

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
     * Get all rooms
     */
    Route::get('rooms', [
        'as' => 'room.all',
        'uses' => 'Api\v1\RoomsController@all'
    ]);


    /**
     * Get room info by id
     */
    Route::get('room/{id}', [
        'as' => 'room.get',
        'uses' => 'Api\v1\RoomsController@get'
    ]);

    /**
     * group search room
     */

    Route::group(['prefix' => 'room/search'], function () {
        /**
         * search nearby
         */
        Route::post('near', [
            'as' => 'room.search.Near',
            'uses' => 'Api\v1\RoomsController@searchNear'
        ]);
        /**
         * search address
         */
        Route::post('realestate', [
            'as' => 'room.search.realestate',
            'uses' => 'Api\v1\RoomsController@searchRealestate'
        ]);
    });


});

