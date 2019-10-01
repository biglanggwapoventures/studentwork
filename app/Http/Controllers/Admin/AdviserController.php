<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class AdviserController extends Controller
{
    public function showAdvisersListPage(Request $request)
    {
        $advisers = User::where('user_role', User::USER_TYPE_ADVISER)
            ->orderBy('lastname')
            ->get();

        return view('advisers.index', [
            'advisers' => $advisers
        ]);
    }

    public function showCreateAdviserPage()
    {
        return view('advisers.create');
    }

    public function showEditAdviserPage($teacherId)
    {
        $adviser = User::find($teacherId);

        return view('advisers.edit', [
            'adviser' => $adviser
        ]);
    }

    public function doCreateAdviser(Request $request)
    {
        $request->validate([
            'firstname'      => 'required|string|max:200',
            'lastname'       => 'required|string|max:200',
            'middle_initial' => 'required|string|size:1',
            'username'       => 'required|string|unique:users,username',
        ]);

        $adviser                 = new User();
        $adviser->firstname      = $request->input('firstname');
        $adviser->lastname       = $request->input('lastname');
        $adviser->middle_initial = $request->input('middle_initial');
        $adviser->username       = $request->input('username');
        $adviser->password       = bcrypt($adviser::USER_DEFAULT_PASSWORRD);
        $adviser->user_role      = $adviser::USER_TYPE_ADVISER;
        $adviser->save();

        return redirect('advisers')->with('message', 'New adviser created successfully!');
    }

    public function doUpdateAdviser($id, Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:200',
            'lastname' => 'required|string|max:200',
            'middle_initial' => 'required|string|size:1',
            'username'=> ['required','string', Rule::unique('users')->ignore($id)],
        ]);

        $adviser = User::find($id);
        $adviser->firstname = $request->input('firstname');
        $adviser->lastname = $request->input('lastname');
        $adviser->middle_initial = $request->input('middle_initial');
        $adviser->username = $request->input('username');   
        $adviser->save();

        return redirect('advisers')->with('message', 'Adviser edited successfully!');
    }

    public function doDeleteAdviser($id)
    {
        $adviser = User::find($id);

        $adviser->delete();

        return redirect('advisers')->with('message', 'Adviser deleted successfully!');
    }
}
