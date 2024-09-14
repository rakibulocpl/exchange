@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5 pt-5">
            <div class="col-md-8">
                <div class="card card-small bg-exchange card-custom my-3 p-3 text-center"  style="max-width: 35rem; margin:0 auto;">
                    <form method="POST" id="otpValidationForm" action="{{ route('user.verifyOtp') }}">
                        <h2>Please enter the OTP<br> </h2>
                        <div> <span> sent to</span> <small>{{\Illuminate\Support\Facades\Session::get('usermobile')}}</small> </div>
                        @csrf
                        <input type="hidden" name="mobileno" value="{{\Illuminate\Support\Facades\Session::get('usermobile')}}"  class="required"/>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <input class="m-2 text-center  rounded required"  type="text" id="otp"  name="otp"  placeholder="****" style="width: 150px"   autoFocus/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script>
        $("#otpValidationForm").validate({
            errorPlacement: function () {
                return true;
            },
            rules:{
                otp:{
                    required:true,
                    minlength: 4,
                    maxlength: 4
                }

            },
            submitHandler: function(form){
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.status ==1){
                            location.replace('/');
                        }else if(response.status ==-1){
                            alert(response.message);
                        }
                    }
                });
            }
        });
    </script>
@endsection