<?php

namespace App\Http\Controllers\Adviser;

use Auth;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HandledProjectsController extends Controller
{
    public function index(Request $request)
    {
        /** @var Validator $validator */
        $validator = \Validator::make($request->all(), [
            'academic_year' => 'sometimes|required|date_format:Y',
            'semester'      => 'sometimes|nullable|in:1,2',
        ]);;

        /** @var Builder $query */
        $query = Auth::user()->handledProjects()
                     ->with(['adviser', 'area', 'authors'])
                     ->latest()
                     ->when($q = trim($request->input('title')),
                         function (Builder $query) use ($q) {
                             return $query->where('title', 'like', "%{$q}%");
                         })
                    ->when(in_array($request->input('status'), ['pending', 'approved']),
                        function (Builder $query) use ($request) {
                            return $query->where('project_status', '=', $request->input('status'));
                        });

//        if ($validator->passes()) {
//            $dates = Project::determinePeriod(
//                $request->input('academic_year', date('Y')),
//                $request->input('semester', null)
//            );
//            $query = $query->whereBetween('date_submitted', $dates);
//        }
//
        $projects = $query->paginate(5);


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
