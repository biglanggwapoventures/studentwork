@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <form class="form-inline mb-3" method="get">
                        <div class="form-group">
                            <label class="mr-2">Project</label>
                            <select name="project_id" id="" class="form-control">
                                @foreach($projects as $id => $title)
                                    <option value="{{ $id }}" {{ request('project_id', null) == $id ? 'selected' : '' }}>{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ml-2">
                            <label class="mr-2">Academic Year</label>
                            <select name="academic_year" id="" class="form-control">
                                @foreach(range(date('Y'), 1999, -1) as $year)
                                    <option value="{{ $year }}" {{ request('academic_year', $selectedYear) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ml-2">
                            <label class="mr-2">Semester</label>
                            <select name="semester" id="" class="form-control">
                                <option value="1" {{ request('semester', $selectedSemester) == 1 ? 'selected' : '' }}>1st Sem
                                </option>
                                <option value="2" {{ request('semester', $selectedSemester) == 2 ? 'selected' : '' }}>2nd Sem
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-secondary ml-2">Search</button>
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">
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


        var xAxis = @json($data->pluck('period')->toArray());
        var yAxis = @json($data->pluck('value')->toArray());

        var config = {
          type: 'line',
          data: {
            labels: xAxis,
            datasets: [{
              label: 'Number of unique visitors',
              backgroundColor: '#4cc0c0',
              borderColor: '#4cc0c0',
              data: yAxis,
              fill: false,
            }]
          },
          options: {
            responsive: true,
            title: {
              display: true,
              text: 'Number of unique visitors per month'
            },
            tooltips: {
              mode: 'index',
              intersect: false,
            },
            hover: {
              mode: 'nearest',
              intersect: true
            },
            scales: {
              xAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'Month'
                }
              }],
              yAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'Unique visitors count'
                },
                ticks: {
                  precision: 0
                }
              }]
            }
          }
        };

        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
      })
    </script>
@endpush