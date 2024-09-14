@extends('layouts.admin')
@section('content')
    <div class="row grid-margin">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Monthly Attendance</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group"  id="parent_section">
                                <label>Year</label>
                                <select class="js-example-basic-single form-control" id="year" name="year">
                                    @foreach($years as $key=>$value)
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group"  id="parent_section">
                                <label>Month</label>

                                {!! Form::select('month',$months, $current_month, $attributes = array('class'=>'js-example-basic-single form-control',
           'id'=>"month")) !!}
                            </div>
                        </div>
                        <div class="col-md-3 ">
                            <div class="form-group"  id="parent_section">
                                <label>Employee</label>
                                {!! Form::select('employee',$employee, '', $attributes = array('class'=>'js-example-basic-single form-control',
           'id'=>"employee")) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <br>
                            <button type="button" class="btn btn-success mr-2" id="filter_attedance">Search</button>

                        </div>
                    </div>

                    <br>
                    <div class="row">

                        <div class="table-responsive  col-md-8" id="logcontent">

                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Attendance Graph</h6>
                                    <div class="w-75 mx-auto">
                                        {{--                                <div class="d-flex justify-content-between text-center">--}}
                                        {{--                                    <div class="wrapper">--}}
                                        {{--                                        <h4>$2256</h4>--}}
                                        {{--                                        <small class="text-muted">Totel sales</small>--}}
                                        {{--                                    </div>--}}
                                        {{--                                    <div class="wrapper">--}}
                                        {{--                                        <h4>584</h4>--}}
                                        {{--                                        <small class="text-muted">Compaign</small>--}}
                                        {{--                                    </div>--}}
                                        {{--                                </div>--}}
                                        <div id="dashboard-donut-chart" style="height:250px"></div>
                                    </div>
                                    <div id="legend" class="donut-legend"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    @include('inc/datatable-script')
    <script>
        $('#filter_attedance').on('click',function () {


            var emp_id = $('#employee').val();
            var year = $('#year').val();
            var month = $('#month').val();
            if(emp_id ==''){
                alert('Please Select Employee');
                return false;
            }
            if(year ==''){
                alert('Please Select year.');
                return false;
            }
            if(month ==''){
                alert('Please Select Select month');
                return  false;
            }

            var data = {
                emp_id: emp_id,
                year: year,
                month: month
            };

            $.ajax({
                url: '{{route("attendance.getattendancebyid")}}',
                method: 'GET',
                data: data,
                dataType: 'json',
                success: function (data) {

                    if (data.responsecode === 1) {
                        $('#logcontent').html(data.content);
                        $('#dashboard-donut-chart').empty();
                        $('#legend').empty();
                        $(function() {
                            var total = data.total;
                            var browsersChart = Morris.Donut({

                                element: 'dashboard-donut-chart',
                                data: data.chart,
                                resize: true,
                                colors: data.colors,
                                formatter: function(value, data) {
                                    return Math.floor(value / total * 100) + '%';
                                }
                            });

                            browsersChart.options.data.forEach(function(label, i) {
                                var legendItem = $('<span></span>').text(label['label']).prepend('<span>&nbsp;</span>');
                                legendItem.find('span')
                                    .css('backgroundColor', browsersChart.options.colors[i]);
                                $('#legend').append(legendItem)
                            });
                        });
                    } else {
                        alert('Something wrong!!.');
                    }
                },
                error: function () {
                    console.log('error');
                },
                completed: function () {
                }

            });


        });

    </script>
@endsection
