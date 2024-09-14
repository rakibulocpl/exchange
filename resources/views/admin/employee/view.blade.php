@extends('layouts.admin')
@section('content')
    <style>
        .profile-image img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 150px;
        }

        .profile-image img:hover {
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }

    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">About  [#ID {{$employee->emp_id}}]</h4>
                                            <form class="forms-sample" action="{{route('employee.update',['employee'=>$employee->id])}}" method="post">
                                                {{method_field('put')}}

                                                <div class="form-group">
                                                    <label>Name : {{$employee->name}}</label>
                                                </div>

                                                <div class="form-group"  id="parent_section">
                                                    <label>Position : {{$postion[$employee->position_id]}}</label>
                                                </div>
                                                <div class="form-group"  id="parent_section">
                                                    <label>Status : @if($employee->status==1) <span  class='btn btn-success btn-xs'> Active</span>@else <span  class='btn btn-xs btn-danger'>In Active</span>@endif</label>

                                                </div>
                                                <div class="profile-image">
                                                    <img class="img-fluid" style="height: 150px;width: 160px;" src="{{!empty($employee->image_url) ? url($employee->image_url):url('images/blank.png')}}" alt="image">
                                                </div>
                                                <br>
                                                <a class="btn btn-light" href="{{route('employee.list')}}"><i class="fa fa-arrow-left"></i>Back</a>
                                                <a href="{{route('employee.edit',[$employee->id])}}" class="btn btn-success mr-2"><i class="fa fa-edit"></i> Edit</a>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        @if($total !=0)
                                            <div class="card-body">
                                                <h6 class="card-title">Attendance Graph ({{$last_nonth_name}})</h6>
                                                <div class="w-75 mx-auto">
                                                    <div id="dashboard-donut-chart" style="height:250px"></div>
                                                </div>
                                                <div id="legend" class="donut-legend"></div>
                                            </div>
                                        @endif
                                    </div>
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
    <script>
        $('#category_type').on('change',function () {
            if ($(this).is(':checked')){
                $('#parent_section').slideDown();
            }else{
                $('#parent_category').val('');
                $('#parent_section').slideUp();
            }
        });
        var aa = '{{$chart_data}}';
        console.log(aa);

        $(function() {
            $('#dashboard-donut-chart').empty();
            $('#legend').empty();
            var total = {{$total}};
            var browsersChart = Morris.Donut({

                element: 'dashboard-donut-chart',
                data: <?=$chart_data?>,
                resize: true,
                colors: <?=$color?>,
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





    </script>
@endsection
