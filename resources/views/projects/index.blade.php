@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    List of all projects
                    <a class="btn btn-success px-3" href="{{ url('projects/create') }}">Create new project</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 table-hover table-striped">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th></th>
                                <th>Project Title</th>
                                <th>Authors</th>
                                <th>Panel</th>
                                <th>Adviser</th>
                                <th>Area</th>
                                <th>Call Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $project->title }}</td>
                                    <td>
                                        <ol class="pl-3">
                                            <li>{!! $project->authors->implode('fullname', '</li><li>') !!}</li>
                                        </ol>
                                    </td>
                                    <td>
                                        <ol class="pl-3">
                                            <li>{!! $project->panel->implode('fullname', '</li><li>') !!}</li>
                                        </ol>
                                    </td>
                                    <td>{{ $project->adviser->fullname }}</td>
                                    <td>{{ $project->area->name }}</td>
                                    <td>{{ $project->call_number ?: 'N/A' }}</td>
                                    <td>
                                        @if($project->is('pending'))
                                            <span class="d-block badge badge-secondary text-white mb-3">PENDING</span>
                                        @elseif($project->is('rejected'))
                                            <span class="d-block badge badge-danger text-white mb-3">REJECTED</span>
                                        @else
                                            <span class="d-block badge badge-success text-white mb-3">APPROVED</span>
                                        @endif

                                        @if(Auth::user()->isRole('adviser'))
                                            <a href="{{ url("my-handled-projects/{$project->id}") }}" class="mr-2">Review</a>
                                        @else
                                            <a href="{{ url("projects/{$project->id}/edit") }}" class="mr-2">Edit</a>
                                            <a href="#" class="text-danger">Delete</a>
                                        @endif
                                        
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
