<?php

namespace Wingi\Http\Controllers\Controllers\Api\v1;

use Illuminate\Http\Request;
use Wingi\Entities\User;
use Wingi\Http\Controllers\Controller;
use Wingi\Http\Requests;

class UserController extends Controller
{

    /**
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->save();

        return response()->json([
            'status' => true,
        ]);
    }
}
