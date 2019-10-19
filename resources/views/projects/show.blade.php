@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-titletext-uppercase mb-4">
                        View project
                        @if($project->is('approved'))
                            <span class="badge badge-success text-white float-right"><i class="fas fa-check"></i> APPROVED</span>
                        @elseif($project->is('rejected'))
                        <span class="badge badge-danger text-white float-right"><i class="fas fa-times"></i> REJECTED</span>
                        @endif
                    </h5>
                        
                    <dl class="row">
                        <dt class="col-md-2">Title</dt>
                        <dd class="col-md-10">
                            {{ $project->title }}
                        </dd>
                        <dt class="col-md-2">DOI</dt>
                        <dd class="col-md-10">
                            {{ $project->doi }}
                        </dd>
                        <dt class="col-md-2">Authors</dt>
                        <dd class="col-md-10">
                            <ol class="pl-3">
                                <li>{!! $project->authors->implode('fullname', '</li><li>') !!}</li>
                            </ol>
                        </dd>
                        <dt class="col-md-2">Keywords</dt>
                        <dd class="col-md-10">
                            <ol class="pl-3">
                                <li>{!! $project->keywords_collection->implode( '</li><li>') !!}</li>
                            </ol>
                        </dd>
                        <dt class="col-md-2">Abstract</dt>
                        <dd class="col-md-10">
                            {!! nl2br($project->abstract) !!}
                        </dd>
                        <dt class="col-md-2">Adviser</dt>
                        <dd class="col-md-10">
                            {{ $project->adviser->fullname }}
                        </dd>
                        <dt class="col-md-2">Panel</dt>
                        <dd class="col-md-10">
                            <ol class="pl-3">
                                <li>{!! $project->panel->implode('fullname', '</li><li>') !!}</li>
                            </ol>
                        </dd>
                        <dt class="col-md-2">Area</dt>
                        <dd class="col-md-10">
                            {{ $project->area->name }}
                        </dd>

                        <dt class="col-md-2">Call #</dt>
                        <dd class="col-md-10">
                            {{ $project->area->call_number }}
                        </dd>

                        <dt class="col-md-2">Date Submitted</dt>
                        <dd class="col-md-10">
                            {{ date_create_immutable($project->date_submitted)->format('F d, Y') }}
                        </dd>

                        <dt class="col-md-2">Pages</dt>
                        <dd class="col-md-10">
                            {{ $project->pages }}
                        </dd>

                        <dt class="col-md-2">Year Published</dt>
                        <dd class="col-md-10">
                            {{ $project->year_published }}
                        </dd>


                        <dt class="col-md-2"></dt>
                        <dd class="col-md-10">
                            <a class="btn btn-sm btn-info text-white" href="{{ url($project->getPreviewLink()) }}" target="_blank" class="mr-3"><i class="fa fa-file"></i> Preview</a>
                        </dd>
                    </dl>
                    @if($project->is('pending'))
                    <div class="row">
                        <div class="col-sm-4 offset-sm-4">
                            <div class="border  p-3 rounded bg-info text-white">
                                <form action="{{ url("my-handled-projects/{$project->id}") }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <div class="form-group">
                                        <label for="">Update status</label>
                                        <select name="project_status"  class="form-control">
                                            <option value="">Pending</option>
                                            <option value="approved">Approve</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-light btn-block">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
