<?php

namespace Wingi\Http\Controllers\Controllers\Api\v1;

use Illuminate\Http\Request;
use Wingi\Entities\User;
use Wingi\Http\Controllers\Controller;
use Wingi\Http\Requests;

class UserController extends Controller
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

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $request->input('phone'),
        ]);

        $user->save();

        return response()->json([
            'status' => true,
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

        if ($user->save())
            // save ok
            return response()->json([
                'status' => true,
            ]);

        // save failed
        return response()->json([
            'status' => false,
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


        if ($user->delete())
            // save ok
            return response()->json([
                'status' => true,
            ]);

        // save failed
        return response()->json([
            'status' => false,
        ]);
    }
}
