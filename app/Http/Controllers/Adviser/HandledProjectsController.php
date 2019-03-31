<?php

namespace App\Http\Controllers\Adviser;

use Auth;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class HandledProjectsController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->handledProjects()->with(['adviser', 'area', 'authors'])->get();

        return view('projects.index', [
            'projects' => $projects
        ]);
    }



    public function show(Project $project)
    {   
        $project->load(['adviser', 'area', 'authors']);
        
        return view('projects.show', [
            'project' => $project,
        ]);
    }

    public function update(Project $project, Request $request)
    {   
       $request->validate([
           'project_status' => 'required|in:rejected,approved'
       ]);

       $project->project_status = $request->input('project_status');

       $project->save();

        return redirect()->back();
    }
}
