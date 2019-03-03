@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center text-uppercase font-weight-bold">
                    Student Work Management System  
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-4 text-center">Please input credentials</h5>
                    @if($errors->all())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($message = session('message'))
                        <div class="alert alert-success text-success">{{ $message }}</div>
                    @endif
                    <form method="post" action="{{ url('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Input username here">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" placeholder="Input password here">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
