<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

/**
 * Undocumented class
 */
class ProfileController extends Controller
{
    public function showProfilePage(Request $request)
    {
        return view('profile', [
            'profile' => Auth::user()
        ]);
    }

    public function doUpdateProfile(Request $request)
    {
        $validated = $request->validate([
            'firstname'      => 'required|string|max:200',
            'lastname'       => 'required|string|max:200',
            'middle_initial' => 'required|string|size:1',
            'password'       => 'present|nullable|string|min:4|confirmed',
        ]);

        if($password = $validated['password']){
            $validated['password'] = bcrypt($password);
        }else{
            unset($validated['password']);
        }

        Auth::user()->fill($validated)->save();

        return redirect('profile')->with('message', [
            'type' => 'success',
            'message' => 'Profile has been successfully updated'
        ]);
    }
}
