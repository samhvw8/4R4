<?php

namespace r4r\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use r4r\Entities\User;
use r4r\Entities\Admin as Admin;
use r4r\Http\Controllers\Controller;
use r4r\Http\Requests;

class UsersController extends Controller
{

    public function login(){
        $user = \Auth::user();

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }

    /**
     * Get all users in database
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $users = User::all();

        return response()->json([
            'status' => true,
            'data' => [
                'total' => $users->count(),
                'users' => $users
            ]
        ]);
    }

    /**
     * Create a user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
        ];

        $user = new User($data);

        try {
            $user->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);

        }

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }

    /**
     * Get user by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {

        $user = User::find($id);

        // if user not found

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        // user found

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }

    /**
     * Update User by ID
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // if user not found

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        // user found
        $user['name'] = $request->input('name');
        $user['email'] = $request->input('email');
        $user['password'] = bcrypt($request->input('password'));
        $user['phone'] = $request->input('phone');


        try {
            $user->save();
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);
        }

        // save success
        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * Delete user by ID
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $user = User::find($id);

        // if user not found

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }


        try {
            $user->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            // delete failed
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);
        }

        // delete success
        return response()->json([
            'status' => true,
        ]);
    }

    /**
     * return user's rooms
     */
    public function getRoom($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        $rooms = $user->rooms()->get();

        return response()->json([
            'status' => true,
            'data' => [
                'total' => $rooms->count(),
                'rooms' => $rooms
            ]
        ]);

    }

    /**
     * return admin list
     * @return mixed
     */
    public function allAdmin()
    {
        $admins = Admin::all();

        return response()->json([
            'status' => true,
            'data' => [
                'total' => $admins->count(),
                '$admins' => $admins
            ]
        ]);
    }

    /**
     * Make user become admin by id
     * @param $id
     * @return mixed
     */
    public function makeAdmin($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        $admin = new Admin();

        try {
            $admin->user()->associate($user)->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ], 500);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'admin' => $admin
            ]
        ]);

    }

    /**
     * Delete role admin of user
     * @param $id
     * @return mixed
     */
    public function delAdmin($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        $user->admin()->delete();

        return response()->json([
            'status' => true,
        ]);

    }

    /**
     * Check User is admin ?
     *
     * @param $id
     */
    public function isAdmin($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
                'data' => [
                    'msg' => 'user id not found'
                ]
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'admin' => $user->isAdmin()
            ]
        ]);
    }
}

