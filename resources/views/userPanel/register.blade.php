@extends('layouts.user')

@section('content')
<div class="container  align-items-center mx-auto justify-content-center  d-flex ">
    <div class="card card-custom  my-3 p-3">
        <form id="userRegistration" method="post" action="{{route('user.register')}}">
            @csrf
            <div class="position-relative">
                <h2 class="text-muted">Registration</h2>
                <div class="form-row">
                    <div class="form-group col-md-6 "> <label class="required-star" for="fname">FIRST NAME </label>
                        <input type="text" name="fname" class="form-control rounded required"  id="fname"  />
                        <div id="fname_error" class="val_error"></div>
                    </div>
                    <div class="form-group col-md-6 ">
                        <label class=" required-star" for="inputLastName">LAST NAME </label>
                        <input type="text" name="lname" class="form-control required"  id="lastname" />
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 first">
                        <label for="gender" class="required-star">Gender </label>
                        {!! Form::select('gender',[''=>'Select Gender'] +$gender,old('gender'), $attributes = array('class'=>'js-example-basic-single form-control required',
                                                               'id'=>"gender")) !!}
                    </div>
                    <div class="form-group col-md-6 first">
                        <label for="dob">Date Of  Birth </label>
                        <input type="date" class="form-control " id="dob" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 first">
                        <label for="city" class="required-star">City </label>
                        {!! Form::select('city',[''=>'Select City'] +$city,old('city'), $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                'id'=>"city")) !!}
                    </div>
                    <div class="form-group col-md-6 first"> <label for="thana" class="required-star">Thana/Area </label>
                        {!! Form::select('thana',[''=>'Select City'],'', $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                'id'=>"thana")) !!}
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="inputEmail">EMAIL</label>
                        <input type="email" class="form-control"id="inputEmail" />
                    </div>
                    <div class="form-group col-md-6">
                        <label class="required-star" for="inputPhone">PHONE </label>
                        <input type="text" class="form-control required" id="phone" name="phone"  placeholder="01xxxxxxxx"  maxLength="11" />

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="daddress">D. Address </label>
                        <textarea  class="form-control" id="daddress"   placeholder="Your Details Address"></textarea>

                    </div>
                </div>

                <div class="form-button pt-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" value="Register" name="register">
                        <span>Submit</span>
                    </button>
                    <div class="text-center">
                        <br>
                        Already Registered <a class="" href="/"> Sign In</a>
                    </div>

                </div>

            </div>
        </form>

    </div>
</div>
@endsection

@section('footer-script')

    <script>
        $("#city").on("change",function (){
            let cityid = $(this).val();
            $.ajax({
                url: 'info/get-thana/'+cityid,
                type: "GET",
                success: function(response) {
                    var option = '<option value="">Select One</option>';
                    $.each(response, function (key, row) {
                        option += '<option selected="true" value="' + row.id + '">' + row.display + '</option>';
                    });
                    $("#thana").html(option)
                }
            });
        });
        $("#userRegistration").validate();
    </script>
@endsection