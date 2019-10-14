@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        List of all projects
                        @if(in_array(Auth::user()->user_role, [\App\User::USER_TYPE_ADMIN, \App\User::USER_TYPE_ADVISER]))
                            <form class="form-inline" method="get">
                                {{--<div class="form-group d-none">--}}
                                    {{--<label class="mr-2">Academic Year</label>--}}
                                    {{--<select name="academic_year" id="" class="form-control">--}}
                                        {{--@foreach(range(date('Y'), 1999, -1) as $year)--}}
                                            {{--<option value="{{ $year }}">{{ $year }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="form-group ml-2 d-none">--}}
                                    {{--<label class="mr-2">Semester</label>--}}
                                    {{--<select name="semester" id="" class="form-control">--}}
                                        {{--<option value="">All</option>--}}
                                        {{--<option value="1">1st Sem</option>--}}
                                        {{--<option value="2">2nd Sem</option>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                                <div class="form-group ml-2">
                                    <label class="mr-2">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ request('title') }}">
                                </div>
                                <button type="submit" class="btn btn-secondary ml-2">Search</button>
                            </form>
                        @endif
                        @if(!Auth::user()->isRole('adviser'))
                            <a class="btn btn-success px-3" href="{{ url('projects/create') }}">Create new project</a>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0 table-hover table-striped">
                            <thead>
                            <tr class="bg-success text-white">
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
                                    <td>
                                        {{ $project->title }}
                                        <br>
                                        <a href="{{ url($project->getPreviewLink()) }}" target="_blank" class="mr-3">Preview</a>
                                    </td>
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
                                      <!--  @elseif($project->is('rejected'))
                                            <span class="d-block badge badge-danger text-white mb-3">REJECTED</span> -->
                                        @else
                                            <span class="d-block badge badge-success text-white mb-3">APPROVED</span>
                                        @endif

                                        @if(Auth::user()->isRole('adviser'))
                                            <a href="{{ url("my-handled-projects/{$project->id}") }}" class="mr-2">Review</a>
                                        @else
                                            <a href="{{ url("projects/{$project->id}/edit") }}"
                                               class="btn btn-info btn-block mb-2">Edit</a>
                                            @if($project->is('pending'))
                                                <form method="post" action="{{ url("projects/{$project->id}") }}"
                                                      onsubmit="javascript: return confirm('Are you sure?')">
                                                    <button type="submit" class="btn btn-danger  btn-block s-2">Delete
                                                    </button>
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center mt-2 d-flex justify-content-center">
                    {{ $projects->appends(request()->all())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
