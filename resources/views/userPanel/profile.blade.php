@extends('layouts.user')
@section('content')

    <div class="container">

        <div class="row user-profile">
            <div class="col-md-3 page-sider">
                <aside>
                    <div class="inner-box">
                        <div class="user-panel-sider">
                            <div class="collapse-box">
                                <h5 class="collapse-title no-border">
                                    My Account&nbsp;
                                    <a href="#MyClassified" data-bs-toggle="collapse" class="float-end"><i class="fa fa-angle-down"></i></a>
                                </h5>
                                <div class="panel-collapse collapse show" id="MyClassified">
                                    <ul class="acc-list">
                                        <li>
                                            <a class="active" href="/my-account">
                                            <i class="fa fa-home"></i> Personal Home
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="collapse-box">
                                <h5 class="collapse-title">
                                    My Deal
                                    <a href="#MyAds" data-bs-toggle="collapse" class="float-end"><i class="fa fa-angle-down"></i></a>
                                </h5>
                                <div class="panel-collapse collapse show" id="MyAds">
                                    <ul class="acc-list">
                                        <li>
                                            <a href="/my-deal"><i class="icon-docs"></i> Deal List&nbsp;</a>

                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-lg-8 side-right stretch-card">
                <div class="card card-default">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a href="#userPanel" aria-expanded="true" data-bs-toggle="collapse" data-parent="#accordion">Account Details</a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse show" id="userPanel">
                        <div class="card-body">
                            <form name="details" class="form-horizontal" role="form" method="POST" action="#" encType="multipart/form-data" id="userProfile">



                                <div class="row mb-3 required">
                                    <label class="col-md-3 col-form-label required-star">Name </label>
                                    <div class="col-md-9">
                                        <input name="name" type="text" class="form-control" placeholder="" value="{{$userData->name}}" />
                                    </div>
                                </div>




                                <div class="row mb-3 required">
                                    <label class="col-md-3 col-form-label">Email</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="{{$userData->email}}" />
                                        </div>
                                    </div>
                                </div>
                                <input name="country_code" type="hidden" value="BD"/>
                                <div class="row mb-3 required">
                                    <label htmlFor="phone" class="col-md-3 col-form-label">Phone</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="form-control text-danger"><b>{{$userData->phone}}</b></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 required">
                                    <label htmlFor="phone" class="col-md-3 col-form-label">Gender</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::select('gender',[''=>'Select Gender'] +$gender,$userData->gender=='female'?2:1, $attributes = array('class'=>'js-example-basic-single form-control required',
                                                               'id'=>"gender")) !!}
                                        </div>
                                    </div>
                                </div>



                                <div class="row mb-3 required">
                                    <label htmlFor="phone" class="col-md-3 col-form-label">City</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::select('city',[''=>'Select City'] +$city,$userData->city, $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                'id'=>"city")) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 required">
                                    <label htmlFor="phone" class="col-md-3 col-form-label">Thana</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::select('thana',[''=>'Select City'],'', $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                   'id'=>"thana")) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 required">
                                    <label htmlFor="phone" class="col-md-3 col-form-label">Details Address</label>
                                    <div class="col-md-9">
                                        <div class="input-group">

                                    <textarea id="daddress" name="daddress"  class="form-control" placeholder="Details Address" value="{{$userData->details_address }}">
                                    </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="offset-md-3 col-md-9"></div>
                                </div>


{{--                                <div class="row">--}}
{{--                                    <div class="offset-md-3 col-md-9">--}}
{{--                                        <button type="submit" class="btn btn-primary">Update</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer-script')
    <script>
        $(document).ready(function() {

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
            $("#city").trigger("change");
        });

        $("#userProfile").validate();
    </script>
@endsection
