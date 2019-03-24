<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Area;
use Illuminate\Validation\Rule;

class AreaController extends Controller
{
    public function showAreasListPage()
    {
        $areas = Area::orderBy('name')->get();
        return view('areas.index', [
            'areas' => $areas 
        ]);
    }

    public function showCreateAreaPage()
    {
        return view('areas.create');
    }

    public function showEditAreaPage($areaId)
    {
        $area = Area::find($areaId);

        return view('areas.edit', [
            'area' => $area
        ]);
    }

    public function doCreateArea(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200|unique:areas'
        ]);

        $area = new Area();
        $area->name = $request->input('name');
        $area->save();

        return redirect('areas')->with('message', 'New area successfully created!');
    }

    public function doUpdateArea(Request $request, $areaId)
    {
        $request->validate([
            'name' => [
                'required',
                'max:200',
                Rule::unique('areas')->ignore($areaId)
            ]
        ]);

        $area = Area::find($areaId);
        $area->name = $request->input('name');
        $area->save();

        return redirect('areas')->with('message', 'Area has been successfully updated!');
    }

    public function doDeleteArea($id)
    {
        $area = Area::find($id);

        $area->delete();

        return redirect('areas')->with('message', 'Area deleted successfully!');
    }
}
