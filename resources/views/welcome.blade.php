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
                @foreach($projects as $project)
                <div class="card-body border-bottom">
                    <h5 class="card-title font-weight-bold mb-4">{{ $project->title }}</h5>
                    <h6 class="card-subtitle mb-2"><strong>Author(s): </strong> {{ $project->authors }}</h6>
                    <h6 class="card-subtitle mb-4"><strong>Date Submitted: </strong>{{ date_create_immutable($project->date_submitted)->format('F d, Y') }}</h6>
                    <h6 class="card-subtitle mb-1"><strong>Abstract</strong></h6>
                    <p class="card-text">{{ $project->abstract }}</p>
                    <h6 class="card-subtitle mb-2"><strong>Call No.: </strong> {!! $project->call_number ?: '<small class="text-muted">n/a</small>' !!}</h6>
                    <h6 class="card-subtitle mb-4">
                        <strong>Keywords: </strong>
                        <span class="badge badge-pill badge-info text-white">{!! implode('</span> <span class="badge badge-pill badge-info text-white">', explode(',', $project->keywords)) !!}</span>
                    </h6>
                </div>
                @endforeach
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
