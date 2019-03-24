<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);

        $loggedIn = Auth::attempt($credentials);

        if($loggedIn){
            return redirect('/')->with('loginMessage', "Welcome, {$credentials['username']}!");
        }
    }
}
