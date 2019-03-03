@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    List of all advisers
                    <a class="btn btn-success px-3" href="{{ url('advisers/create') }}">Create new adviser</a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0 table-hover table-striped">
                        <thead>
                            <tr class="bg-primary text-white">
                                <th></th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>M.I</th>
                                <th>Username</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($advisers as $adviser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $adviser->lastname }}</td>
                                    <td>{{ $adviser->firstname }}</td>
                                    <td>{{ $adviser->middle_initial }}</td>
                                    <td>{{ $adviser->username }}</td>
                                    <td>
                                        <a href="#" class="mr-2">Edit</a>
                                        <a href="#" class="text-danger">Delete</a>
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
