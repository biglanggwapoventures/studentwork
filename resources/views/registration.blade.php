@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center text-uppercase font-weight-bold">
                    Student Work Management Information System  
                </div>
                <div class="card-body">
                    <h5 class="card-title text-center text-uppercase mb-4">Registration form</h5>
                    <div class="alert alert-success text-success">All input field with * are required.</div>
                    @if($errors->all())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ url('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><font color="red"> *</font> First Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><font color="red"> *</font>Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Middle Initial</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="middle_initial" value="{{ old('middle_initial') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><font color="red"> *</font>Birthdate</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="birthdate" value="{{ old('birthdate') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><font color="red"> *</font>Contact Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contact_number" value="{{ old('contact_number') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><font color="red"> *</font>Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-3 col-form-label"><font color="red"> *</font>Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><font color="red"> *</font>Password Confirmation</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control"  name="password_confirmation">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
