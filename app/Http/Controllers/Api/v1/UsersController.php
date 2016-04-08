<?php

namespace r4r\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use r4r\Entities\User;
use r4r\Http\Controllers\Controller;
use r4r\Http\Requests;

class UsersController extends Controller
{

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
            'password' => $request->input('password'),
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
            ]);

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
            ]);
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
            ]);
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
            ]);
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
            ]);
        }


        try {
            $user->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => false,
                'data' => [
                    'code' => $e->getCode(),
                    'msg' => $e->errorInfo[2]
                ]
            ]);
        }

        // save failed
        return response()->json([
            'status' => false,
        ]);
    }

    /**
     * return user's room
     */
    public function getRoom($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->json([
                'status' => false,
            ]);
        }

        $rooms = $user->rooms();

        return response()->json([
            'status' => true,
            'data' => [
                'rooms' => $rooms
            ]
        ]);

    }
}

