<?php
/**
 * Created by PhpStorm.
 * User: adriannatabio
 * Date: 05/10/2019
 * Time: 1:51 PM
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ReportsController extends \App\Http\Controllers\Adviser\ReportsController
{
    protected function prepareData(Request $request)
    {
        $projects = collect();
        if ($adviserId = $request->input('adviser', null)) {
            $projects = User::query()->find($adviserId)
                            ->handledProjects()
                            ->whereNotNull('date_submitted')
                            ->where('project_status', '=', 'approved')
                            ->get();
        }

        return $this->formatData($projects);
    }
}