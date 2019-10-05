<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function showRegistrationPage()
    {
        return view('registration');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'firstname'      => 'required|string|max:200',
            'lastname'       => 'required|string|max:200',
            'middle_initial' => 'nullable|string|size:1',
            'birthdate'      => 'required|date',
            'contact_number' => 'required|string|size:11',
            'username'       => 'required|string|max:200|unique:users',
            'password'       => 'required|string|min:4|confirmed',
        ]);

        $user                 = new User();
        $user->firstname      = $request->input('firstname');
        $user->lastname       = $request->input('lastname');
        $user->middle_initial = $request->input('middle_initial');
        $user->birthdate      = $request->input('birthdate');
        $user->contact_number = $request->input('contact_number');
        $user->username       = $request->input('username');
        $user->password       = bcrypt($request->input('password'));
        $user->user_role      = $user::USER_TYPE_STUDENT;
        $user->save();

        return redirect('login')->with('message', 'Registration successful! You can now login using your credentials!');
    }
}
