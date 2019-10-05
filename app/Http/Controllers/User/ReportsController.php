<?php

namespace App\Http\Controllers\User;

use App\Project;
use App\ProjectTraffic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function monthlyViews(Request $request)
    {
        $projects = Auth::user()->projects()->select('projects.id', 'projects.title')->get()->pluck('title', 'id');
        $period   = $this->getCurrentPeriod($request);
        $data     = [];

        if ($projectId = $request->input('project_id', null)) {
            $data = $this->getData($projectId, $period['period']);
        }


        return view('reports.monthly-view', array_merge($period, compact('projects', 'data')));
    }

    protected function getData(int $projectId, array $period)
    {
        $result = collect();

        /** @var Collection $data */
        $data = \DB::table((new ProjectTraffic())->getTable())
                   ->selectRaw('COUNT(DISTINCT user_id) as visitors, MONTH(created_at) as month')
                   ->where('project_id', $projectId)
                   ->whereRaw("DATE(created_at) BETWEEN '{$period[0]}' AND '{$period[1]}'")
                   ->groupBy(\DB::raw('MONTH(created_at)'))
                   ->orderBy('month')
                   ->get()
                   ->pluck('visitors', 'month');

        $startOfSem = Carbon::parse($period[0]);
        $endOfSem   = Carbon::parse($period[1]);

        while ($startOfSem->lessThanOrEqualTo($endOfSem)) {
            $result->push([
                'period' => $startOfSem->format('F Y'),
                'value'  => $data->get($startOfSem->format('n'), 0)
            ]);
            $startOfSem = $startOfSem->addMonth(1);
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getCurrentPeriod(Request $request)
    {
        $selectedYear = $request->input('academic_year', date('Y'));

        $month      = date('m');
        $currentSem = in_array((int) $month, range(8, 12)) ? 1 : 2;

        $selectedSemester    = $request->input('semester', $currentSem);
        $period = Project::determinePeriod($selectedYear, $selectedSemester);

        return array_merge(compact('selectedYear', 'month', 'selectedSemester', 'period'));
    }
}
