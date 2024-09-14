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
                                        <h4 class="card-title">Edit Employee [ID {{$employee->emp_id}}]</h4>
                                        <form class="forms-sample" action="{{route('employee.update',['employee'=>$employee->id])}}" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            {{--                                            <div class="form-check form-check-flat">--}}
                                            {{--                                                <label class="form-check-label">--}}
                                            {{--                                                    <input type="checkbox" name="category_type" id="category_type" class="form-check-input" >--}}
                                            {{--                                                    Sub Category--}}
                                            {{--                                                </label>--}}
                                            {{--                                            </div>--}}

                                            {{method_field('put')}}

                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"  value="{{$employee->name}}" placeholder="Name">
                                            </div>

                                            <div class="form-group"  id="parent_section">
                                                <label>Position</label>
                                                {!! Form::select('position_id',[''=>'Select Position','1'=>'Manager','2'=>'Asst Manager'], $employee->position_id, $attributes = array('class'=>'js-example-basic-single form-control',
                           'id'=>"parent_category")) !!}
                                            </div>
                                            <div class="form-group"  id="parent_section">
                                                <label>Status</label>
                                                {!! Form::select('status',[0=>'In-Active','1'=>'Active'], $employee->status, $attributes = array('class'=>'js-example-basic-single form-control',
                           'id'=>"parent_category")) !!}
                                            </div>
                                                <label for="monthly_medicine" class=" required-star">Employee Image:</label>
                                                <div    >
                                                    <span id="applicant_logo_err" class="text-danger" style="font-size: 10px;"></span>
                                                    {!! Form::file('applicant_image',['class'=>'required',
                                                    'data-rule-maxlength'=>'100','onchange'=>'applicantImage(this)'])!!}<br>
                                                    <span class="text-danger" style="font-size: 9px; font-weight: bold">[File Format: *.jpg/ .jpeg/ .png | File size must be <br>width 300px and height 300px, Max:100k]</span><br/>

                                                    <div style="position:relative;">
                                                        <img id="applicantLogoViewer"
                                                             style="width:100px;height:90px;position:absolute;top:-56px;right:0px;border:1px solid #ddd;padding:2px;background:#a1a1a1;"
                                                             src="{{!empty($employee->image_url) ? url($employee->image_url):url('images/blank.png')}}" alt="">
                                                    </div>
                                                    {!! $errors->first('applicant_photo','<span class="help-block">:message</span>') !!}
                                                </div>
                                            <br>
                                            <a class="btn btn-light" href="{{route('employee.list')}}">Cancel</a>
                                            <button type="submit" class="btn btn-success mr-2">Update</button>
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
        $('#category_type').on('change',function () {
            if ($(this).is(':checked')){
                $('#parent_section').slideDown();
            }else{
                $('#parent_category').val('');
                $('#parent_section').slideUp();
            }
        });

        function applicantImage(input) {
            if (input.files && input.files[0]) {
                $("#applicant_logo_err").html('');
                var mime_type = input.files[0].type;
                if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
                    alert('Image format is not valid. Only PNG or JPEG or JPG type images are allowed.');
                    $("#imgApplicant").val('');
                    $("#applicant_logo_err").html("Image format is not valid. Only PNG or JPEG or JPG type images are allowed.");
                    return false;
                }
                var fsize = input.files[0].size;
                if (fsize > 100024) //byte do something if file size more than 1 mb (1048576)
                {
                    alert("Image size must be 100kb");
                    $('#applicant_image').addClass('error required');
                    return false;

                } else {
                    $('#applicant_image').removeClass('error')
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#applicantLogoViewer').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection
