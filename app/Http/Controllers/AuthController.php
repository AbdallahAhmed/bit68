<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class AuthController extends Controller
{

    /**
     * GET/POST /login
     * @route login
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        if ($request->method() == "POST") {
            $error = new MessageBag();
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }

            if (!Auth()->attempt([
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            ])) {
                $error->add('invalid', "Invalid email or password");
                return redirect()->back()->withErrors($error->messages())->withInput($request->all());
            }

            Auth()->login(Auth()->user());
            return redirect()->route('weather');
        }
        return view('welcome');
    }

    /**
     * POST /logout
     * @route login
     * @return string
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
