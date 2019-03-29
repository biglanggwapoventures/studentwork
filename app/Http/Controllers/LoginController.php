<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

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
