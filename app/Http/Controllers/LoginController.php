<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class LoginController extends BaseController
{
    public function loadLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");

        $userData = User::where("userName", $username)->get();

        if ($userData[0]) {
            if ($userData[0]->userPassword == hash("sha512", $password)) {
                Session::put('user', $userData[0]);
                return redirect()->route('inbox');
            } else {
                $error = 2;
                return view('login', compact("error"));
            }
        } else {
            $error = 1;
            return view('login', compact("error"));
        }
    }
}
