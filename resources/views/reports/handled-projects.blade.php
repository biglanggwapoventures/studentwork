@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body">
                        @if(Auth::user()->isRole(\App\User::USER_TYPE_ADMIN))
                        <form class="form-inline mb-3" method="get">

                            <div class="form-group">
                                <label for="" class="mr-2">Adviser</label>
                                <select name="adviser" id="" class="form-control select2 ml-2">
                                    <option value=""></option>
                                    @foreach($advisers AS $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-secondary ml-2">Go</button>
                        </form>
                        @endif
                        <canvas id="canvas"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@push('js')
    <script type="text/javascript" src="{{ asset('js/e.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function () {

        var data = @json($data ?? []);

        var semesterGroup = {
          '1st': [],
          '2nd': []
        };

        var result = [];
        for (var year in data) {
          semesterGroup['1st'].push(data[year]['1']);
          semesterGroup['2nd'].push(data[year]['2'])
        }


        var ctx = document.getElementById("canvas").getContext("2d");

        var data = {
          labels: Object.keys(data),
          datasets: [{
            label: "1st Semester",
            backgroundColor: "#ffe0e6",
            data: semesterGroup['1st']
          },{
            label: "2nd Semester",
            backgroundColor: "#dbf2f2",
            data: semesterGroup['2nd']
          }]
        };

        var myBarChart = new Chart(ctx, {
          type: 'bar',
          data: data,
          options: {
            barValueSpacing: 20,
            scales: {
              yAxes: [{
                ticks: {
                  min: 0,
                  precision: 0
                }
              }]
            }
          }
        });

      })
    </script>
@endpush