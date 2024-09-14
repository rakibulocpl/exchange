@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Leave Form</h4>
                                        <form class="forms-sample" action="{{route('leave.storeleave')}}" method="post" id="leaveform">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            {{--                                            <div class="form-check form-check-flat">--}}
                                            {{--                                                <label class="form-check-label">--}}
                                            {{--                                                    <input type="checkbox" name="category_type" id="category_type" class="form-check-input" >--}}
                                            {{--                                                    Sub Category--}}
                                            {{--                                                </label>--}}
                                            {{--                                            </div>--}}


                                            <div class="form-group">
                                                <label for="name">Employee</label>
                                                {{Form::select('emp_id',[''=>'Select one']+$employees, null, array('class' =>'form-control applyselect required'))}}
                                            </div>

                                            <div class="form-group"  >
                                                <label>Date</label>
                                                <div class="input-daterange input-group" id="datepicker">
                                                    <input type="text" class="input-sm form-control required" name="start" data-date-format="DD/MM/YYYY" onblur="calculateday(this)" id="start_date" />
                                                    <span class="input-group-addon">to</span>
                                                    <input type="text" class="input-sm form-control required" name="end"  data-date-format="DD/MM/YYYY" onblur="(calculateday(this))" id="end_date" />
                                                </div>
                                            </div>
                                            <div id="affected_date">

                                            </div>
                                            <div class="form-group"  >
                                                <label>No of Days</label>
                                                {!! Form::text('no_of_days','', $attributes = array('class'=>' form-control required','readonly',
                           'id'=>"no_of_days")) !!}
                                            </div>
                                            <div class="form-group"  >
                                                <label>Reason</label>
                                                {!! Form::textarea('reason','', $attributes = array('class'=>' form-control required',
                           'id'=>"comment")) !!}
                                            </div>

                                            <div class="form-group"  >
                                                <label>Status</label>
                                                {!! Form::select('status',[0=>'Pending','1'=>'Approved'],'', $attributes = array('class'=>'js-example-basic-single form-control required',
                           'id'=>"parent_category")) !!}
                                            </div>


                                            <button type="submit" class="btn btn-success mr-2">Save</button>
                                            <a class="btn btn-light" href="{{route('leave.list')}}">Cancel</a>
                                        </form>
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
        jQuery.validator.messages.required = "";
        $("#leaveform").validate();

        $('#category_type').on('change',function () {
            if ($(this).is(':checked')){
                $('#parent_section').slideDown();
            }else{
                $('#parent_category').val('');
                $('#parent_section').slideUp();
            }
        });
        $('.applyselect').select2();
        $('.input-daterange').datepicker({
            format: 'yyyy/mm/dd',
            onSelect: function(dateText, inst) {
                alert(dateText);
            }
        });

        function calculateday(test) {
            var value = $("#datepicker input[name=start]").datepicker("getFormattedDate");
            var value2 = $("#datepicker input[name=end]").datepicker("getFormattedDate");
            if(value !=null && value2 !=null){
                $.ajax({
                    type: "GET",
                    url: "{{route('leave.getaffecteddate')}}",
                    data: {
                        startdate: value,
                        enddate: value2
                    },
                    success: function (response) {
                        var option = '';
                        if (response.responseCode == 1) {
                            if(response.date != ''){
                                $('#affected_date').html(response.affecteddate);
                            }else{
                                $('#affected_date').html('');
                            }
                        }
                        $("#no_of_days").val(response.no_of_day);
                    }
                });
            }
        }




    </script>

@endsection
