@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 text-center py-5" style="background:url({{ asset('img/bg.jpeg') }}) top center;background-size:cover;height:400px">
            <img src="{{ asset('img/logo_clean.png') }}" class="img-fluid mx-auto" alt="">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 my-5">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Input keywords">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="button-addon1">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 offset-sm-2">
            <div class="card">
                <div class="card-body border-bottom">
                        <dl class="row">
                            <dt class="col-md-2">Title</dt>
                            <dd class="col-md-10">
                                <h3 class="card-title mb-0" style="font-size:1.2rem">
                                    <a class="text-decoration-none" href="{{ url("view/{$project->id}") }}" >{{ $project->title }}</a>
                                </h3>
                            </dd>
                            <dt class="col-md-2">Authors</dt>
                            <dd class="col-md-10">
                                <span class="badge badge-secondary text-white mr-1">
                                    <i class="fas fa-user fa-fw"></i>
                                    {!! $project->authors->pluck('fullname')->implode('</span><span class="badge badge-secondary mr-1 text-white"><i class="fas fa-user fa-fw"></i>') !!}
                                </span>
                            </dd>
                            <dt class="col-md-2">Keywords</dt>
                            <dd class="col-md-10">
                                <span class="badge badge-pill badge-info text-white mr-1">
                                    {!! $project->keywords_collection->implode('</span><span class="badge badge-pill badge-info mr-1 text-white">') !!}
                                </span>
                            </dd>
                            <dt class="col-md-2">Abstract</dt>
                            <dd class="col-md-10">
                                {{ $project->abstract }}
                            </dd>
                        </dl>
                        <div class="row">
                            <div class="col-1">&nbsp;</div>
                            @forelse($project->getPreviewsFilePath() as $preview)
                                <div class="col-2 text-center">
                                    <a data-fancybox="gallery" href="{{ $preview }}">
                                        <img class="img-fluid border rounded mx-auto" src="{{ $preview }}" alt="{{ $project->title }} preview page {{ $loop->iteration }}" >
                                    </a>
                                </div>
                            @empty
                                No resource
                            @endforelse
                        </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body mt-0">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
