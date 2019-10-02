<?php

namespace App\Http\Controllers;

use App\Area;
use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::query()
                           ->when($areas = $request->input('areas', []), function (Builder $query) use ($areas) {
                               return $query->whereIn('area_id', $areas);
                           })
                           ->when($keywords = $request->input('keywords', []),
                               function (Builder $query) use ($keywords) {
                                   collect($keywords)->each(function ($keyword) use ($query) {
                                       $query->where('keywords', 'LIKE', "%{$keyword}%");
                                   });

                                   return $query;
                               })
                           ->when($adviser = $request->input('adviser_id'), function (Builder $query) use ($adviser) {
                               return $query->where('adviser_id', $adviser);
                           })
                           ->when($authors = $request->input('authors', []), function (Builder $query) use ($authors) {
                               return $query->whereHas('authors', function (Builder $authorsQuery) use ($authors) {
                                   return $authorsQuery->whereIn('author_id', $authors);
                               });
                           })
                           ->where('project_status', 'approved')
                           ->with(['authors', 'area'])
                           ->latest()
                           ->get();

        return view('welcome', array_merge(
            compact('projects'),
            $this->prepareFilters()
        ));
    }

    public function viewProject($projectId)
    {
        $project = Project::find($projectId);

        return view('article', [
            'project' => $project
        ]);
    }

    protected function prepareFilters()
    {
        // users
        $users = User::query()
                     ->select('id', 'firstname', 'lastname', 'middle_initial', 'user_role')
                     ->where('user_role', '!=', User::USER_TYPE_ADMIN)
                     ->orderBy('lastname', 'asc')->get();

        // keywords
        $allKeywords = Project::query()->select(\DB::raw('GROUP_CONCAT(keywords, ",") AS string'))->first();

        $keywords = collect(explode(',', $allKeywords->string))
            ->filter()
            ->map(function ($item) {
                return trim($item);
            })
            ->unique()
            ->all();

        // areas
        $areas = Area::query()
                     ->orderBy('name')
                     ->latest()
                     ->get();

        return array_merge(
            $users->groupBy('user_role')->all(),
            compact('keywords', 'areas')
        );
    }
}
