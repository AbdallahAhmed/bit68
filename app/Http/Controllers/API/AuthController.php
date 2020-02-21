<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends APIController
{
    /**
     * POST /auth
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response['errors'] = ($validator->errors()->all());
            return response()->json($response, '400');
        }

        $isAuthed = Auth()->once([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        if (!$isAuthed) {
            return $this->errorResponse(["Email or password incorrect."], 400);
        }

        $user = Auth()->user();
        $user->save();

        return $this->response(['user' => $user, 'token' => $user->api_token]);
    }

    /**
     * POST /register
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(($validator->errors()->all()));
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');
        $user->api_token = $user->newApiToken();
        $user->save();

        return $this->response(['user' => $user, 'token' => $user->api_token]);
    }

}
