<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Area;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $allKeywords = Project::select(\DB::raw('GROUP_CONCAT(keywords, ",") AS string'))->first();
        
        $keywords = collect(explode(',', $allKeywords->string))
            ->filter()
            ->map(function ($item) {
                return trim($item);
            })
            ->unique()
            ->all();

        $areas = Area::orderBy('name')
            ->latest()
            ->get();

        // dd($keywords);

        $projects = Project::when(($filteredKeywords = $request->input('q', [])), function ($q) use ($filteredKeywords) {
            foreach($filteredKeywords as $keyword){
                $q->where('keywords', 'LIKE', "%{$keyword}%");
            }
        })
        ->approved()
        ->with(['authors', 'area'])
        ->latest()->get();

        return view('welcome', [
            'projects' => $projects,
            'keywords' => $keywords,
            'areas' => $areas
        ]); 
    }

    public function viewProject($projectId)
    {
        $project = Project::find($projectId);
        
        return view('article', [
            'project' => $project
        ]); 
    }
}
