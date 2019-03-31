<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;

class MyProjectsController extends Controller
{
    public function __invoke()
    {
        $projects = Auth::user()->projects()->with(['adviser', 'area', 'authors'])->get();

        return view('projects.index', [
            'projects' => $projects
        ]);
    }
}
