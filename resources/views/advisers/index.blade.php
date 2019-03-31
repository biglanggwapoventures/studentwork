@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if(session('message'))
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        </div>
                    </div>
                @elseif(session('errorMessage'))
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ session('errorMessage') }}
                            </div>
                        </div>
                    </div>
                @endif
                
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
                                        <a href="{{ url("advisers/{$adviser->id}/edit") }}" class="mr-2">Edit</a>
                                        <form class="delete-form" method="POST" action="{{ url("advisers/{$adviser->id}/delete") }}">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <a href="#" onclick="confirmDelete(this)" class="text-danger">Delete
                                            </a>
                                        </form>
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
@push('js')
   <script>
       function confirmDelete(btn) {
           var form = $(btn).closest('form');
        var x = confirm("Are you sure you want to delete?");
            if (x){
                form.submit();
            }
            else {
                return;
            }
       }
   </script>
@endpush

