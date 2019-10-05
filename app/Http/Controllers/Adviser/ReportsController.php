<?php
/**
 * Created by PhpStorm.
 * User: adriannatabio
 * Date: 05/10/2019
 * Time: 1:21 PM
 */

namespace App\Http\Controllers\Adviser;


use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function handledYearly(Request $request)
    {
        return view('reports.handled-projects', [
            'data'     => $this->prepareData($request),
            'advisers' => User::query()
                              ->select('id', 'firstname', 'lastname', 'middle_initial')
                              ->where('user_role', User::USER_TYPE_ADVISER)
                              ->get()
                              ->pluck('fullname', 'id')
        ]);
    }

    protected function prepareData(Request $request)
    {

        /** @var Collection $projects */
        $projects = Auth::user()->handledProjects()
                        ->whereNotNull('date_submitted')
                        ->where('project_status', '=', 'approved')
                        ->get();


        return $this->formatData($projects);
    }

    protected function formatData(Collection $projects) : Collection
    {
        $data = collect();

        $currentYear = date('Y');
        $yearRange   = range($currentYear, $currentYear - 3, -1);

        foreach ($yearRange as $year) {
            $firstSem  = Project::determinePeriod($year, 1);
            $secondSem = Project::determinePeriod($year, 2);

            $data->put($year, [
                '1' => $projects->filter(function (Project $project) use ($firstSem) {
                    return Carbon::parse($project->date_submitted)->between(
                        Carbon::parse($firstSem[0]),
                        Carbon::parse($firstSem[1]),
                        true
                    );
                })->count(),
                '2' => $projects->filter(function (Project $project) use ($secondSem) {
                    return Carbon::parse($project->date_submitted)->between(
                        Carbon::parse($secondSem[0]),
                        Carbon::parse($secondSem[1]),
                        true
                    );
                })->count()
            ]);
        }

        return $data;
    }
}