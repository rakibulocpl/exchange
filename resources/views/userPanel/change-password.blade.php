@extends('layouts.admin')
<link rel="stylesheet" href="/css/jquery.passwordRequirements.css" />
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row user-profile">

        <div class="col-lg-12 side-right stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="wrapper">
                        <label for="change-password">Change password</label>
                        <hr>
                        <div class="tab-content col-md-6" id="myTabContent">
                            <div class="tab-pane fade show active" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <form id="changePassword" method="POST" action="{{ route('user.passwordChange') }}">
                                    @csrf
                                    <div class="form-group">

                                        <input type="password" class="form-control required" name="old-password" id="change_password" placeholder="Enter you current password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control required pr-password" name="password" id="password" placeholder="Enter you new password">
                                    </div>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script src="{{asset('/js/jquery.passwordRequirements.min.js')}}"></script>
    <script>
        $(document).ready(function (){
            $(".pr-password").passwordRequirements({

            });
        });
        jQuery.validator.addMethod("checkpassword", function(password) {
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return regex.test(password);
        }, "* Invalid Password");

        $("#changePassword").validate({
            errorPlacement: function () {
                return true;
            },
            rules: {
                password: {checkpassword:true}
            }
        });
    </script>
@endsection
