@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 pt-5">
        <div class="col-md-8">
            <div class="card card-small bg-exchange card-custom my-3 p-3 text-center"  style="max-width: 35rem; margin:0 auto;">
                    <form method="POST" id="userloginform" action="{{ route('user.sendotp') }}">
                        <h2>Please Login <br> </h2>
                        <span>Enter your Phone Number </span>
                        @csrf

                        <div class="form-group row">
                            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-1">
                                <input class="m-2  form-control rounded" type="text" id="mobileno" name="mobileno" placeholder="01xxxxxxxxx" maxlength="11"><br>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
                                </button>
                                @if (Route::has('user.register'))
                                    <a class="btn btn-link" href="{{ route('user.register') }}">
                                        {{ __('Signup?') }}
                                    </a>
                                @endif
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
        $("#userloginform").validate({
            errorPlacement: function () {
                return true;
            },
            rules:{
                mobileno:{
                    required:true,
                    bd_mobile:true
                }
            },
            submitHandler: function(form){
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.responseCode ==1){
                            location.replace('/verify-otp');
                        }else if(response.responseCode ==-1){
                            alert(response.message);
                        }
                    }
                });
            }
        });
    </script>
@endsection