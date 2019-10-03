<?php

namespace App\Http\Controllers\User;

use App\Project;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class MyProjectsController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var Validator $validator */
        $validator = \Validator::make($request->all(), [
            'academic_year' => 'sometimes|required|date_format:Y',
            'semester'      => 'sometimes|nullable|in:1,2',
        ]);

        $query = Auth::user()->projects()->with(['adviser', 'area', 'authors']);

//        if ($validator->passes()) {
//            $dates = Project::determinePeriod(
//                $request->input('academic_year', date('Y')),
//                $request->input('semester', null)
//            );
//            $query = $query->whereBetween('date_submitted', $dates);
//        }

        $projects = $query->paginate(5);

        return view('projects.index', [
            'projects' => $projects
        ]);
    }
}
