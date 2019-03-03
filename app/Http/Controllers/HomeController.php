<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();

        return view('welcome', [
            'projects' => $projects
        ]); 
    }
}
