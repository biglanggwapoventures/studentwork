<?php

namespace App\Http\Controllers;

use Auth;
use App\Area;
use App\User;
use App\Project;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function showProjectsListPage(Request $request)
    {
        $projects = Project::with(['adviser', 'area', 'authors'])->get();

        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    public function showEditProjectPage(Project $project)
    {
        $project->load(['adviser', 'area', 'authors']);

        $faculty = User::where('user_role', User::USER_TYPE_ADVISER)
            ->orderBy('lastname')
            ->get();

        $areas = Area::orderBy('name')->get();
        $students = User::ofType(User::USER_TYPE_STUDENT)->get();

        return view('projects.edit', [
            'project' => $project,
            'faculty' => $faculty,
            'areas'   => $areas,
            'students' => $students
        ]);
    }

    public function showCreateProjectPage()
    {
        $faculty = User::where('user_role', User::USER_TYPE_ADVISER)
            ->orderBy('lastname')
            ->get();

        $areas = Area::orderBy('name')->get();
        $students = User::ofType(User::USER_TYPE_STUDENT)->get();

        return view('projects.create', [
            'faculty' => $faculty,
            'areas'   => $areas,
            'students' => $students
        ]);
    }

    public function doCreateProject(Request $request)
    {
        $rules = [
            'doi'            => 'nullable|string',
            'title'          => 'required|string',
            'author_ids'      => 'required|array',
            'author_ids.*'    => 'required|exists:users,id|distinct',
            'abstract'       => 'required|string',
            'adviser_id'     => 'required|exists:users,id',
            'area_id'        => 'required|exists:areas,id',
            'panel_ids'      => 'required|array',
            'panel_ids.*'    => 'required|exists:users,id|distinct',
            'keywords'       => 'required|string',
            'pages'          => 'required|integer',
            'year_published' => 'required|date_format:Y',
            'file'           => 'required|mimes:pdf',
        ];

        if (Auth::user()->isRole(User::USER_TYPE_ADMIN)) {
            $rules += [
                'call_number'    => 'required|exists:areas,id',
                'date_submitted' => 'required|date|before:tomorrow',
            ];
        }

        \DB::transaction(function () use ($request, $rules) {
            $request->validate($rules);

            $project                     = new Project();
            $project->doi                = $request->input('doi');
            $project->title              = $request->input('title');
            $project->abstract           = $request->input('abstract');
            $project->adviser_id         = $request->input('adviser_id');
            $project->area_id            = $request->input('area_id');
            $project->keywords           = $request->input('keywords');
            $project->pages              = $request->input('pages');
            $project->year_published     = $request->input('year_published');
            $project->uploaded_file_path =  $request->file('file')->store($request->user()->id, 'public');

            $project->save();
            $project->panel()->attach($request->input('panel_ids'));
            $project->authors()->attach($request->input('author_ids'));

            $this->saveImagePreviews($project->uploaded_file_path);

        });

        return redirect('projects')->with('message', 'New project has been successfully created!');
    }

    public function doEditProject(Project $project, Request $request)
    {
        if(
            $project->is('rejected') // rejecte projects cannot be edited
            ||( $project->is('approved') && !Auth::user()->isRole('admin')) // approved projects can only be edited by admin
        ){
            return redirect()->back();
        }
        

        $rules = [
            'doi'            => 'nullable|string',
            'title'          => 'required|string',
            'author_ids'      => 'required|array',
            'author_ids.*'    => 'required|exists:users,id|distinct',
            'abstract'       => 'required|string',
            'adviser_id'     => 'required|exists:users,id',
            'area_id'        => 'required|exists:areas,id',
            'panel_ids'      => 'required|array',
            'panel_ids.*'    => 'required|exists:users,id|distinct',
            'keywords'       => 'required|string',
            'pages'          => 'required|integer',
            'year_published' => 'required|date_format:Y',
            'file'           => 'nullable|mimes:pdf',
        ];

        if (Auth::user()->isRole(User::USER_TYPE_ADMIN)) {
            $rules += [
                'call_number'    => 'required|exists:areas,id',
                'date_submitted' => 'required|date|before:tomorrow',
            ];
        }

        \DB::transaction(function () use ($request, $rules, $project) {
            $request->validate($rules);
            
            $project->doi                = $request->input('doi');
            $project->title              = $request->input('title');
            $project->abstract           = $request->input('abstract');
            $project->adviser_id         = $request->input('adviser_id');
            $project->area_id            = $request->input('area_id');
            $project->keywords           = $request->input('keywords');
            $project->pages              = $request->input('pages');
            $project->year_published     = $request->input('year_published');

            if($request->hasFile('file')){
                $project->uploaded_file_path = $request->file('file')->store($request->user()->id, 'public');
                $this->saveImagePreviews($project->uploaded_file_path);
            }
            

            $project->save();
            $project->panel()->sync($request->input('panel_ids'));
            $project->authors()->sync($request->input('author_ids'));

        });

        return redirect('projects')->with('message', 'Project has been successfully updated!');
    }


    protected function saveImagePreviews($filePath)
    {
        $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
        $file = new \Imagick($storagePath.$filePath);
        $lastIndex = $file->getNumberImages() > 5 ? 4 : ($file->getNumberImages() - 1);


        foreach (range(0, $lastIndex) as $index) {
            $page = $index + 1;
            $file->setIteratorIndex($index);
            $file->setCompression(\Imagick::COMPRESSION_JPEG);
            $file->setImageFormat("jpeg");
            $filename = Str::replaceLast('.pdf', "-page-{$page}.jpg", $filePath);
            Storage::disk('public')->put($filename, $file);
        }

        return true;
    }

}
