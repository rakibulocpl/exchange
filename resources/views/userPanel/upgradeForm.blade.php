@extends('layouts.user')

@section('content')
    <style>

        body {
            background-color: #FFF;
        }

        .stepwizard-step p {
            margin-top: 0px;
            color: #666;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            /*opacity: 1 !important;
                    filter: alpha(opacity=100) !important;*/
        }

        .stepwizard .btn.disabled,
        .stepwizard .btn[disabled],
        .stepwizard fieldset[disabled] .btn {
            opacity: 1 !important;
            color: #bbb;
        }


        .form_input {
            width: 98%;
            margin-left: 20px;
            margin-right: 50px;
        }


        .cart_head_div {
            border-bottom: 1px solid #e3d0d0 !important;
        }

        .cart_head_div {
            border: none;
        }


        .contact_left_img img {
            max-width: 100%;
        }

        .contact_left_heading h1 {
            text-align: center;
            font-weight: bold;
            color: #00AEEF;
        }


        .contact-us span {
            font-size: 24px;
            font-weight: bold;
        }

        .contact-us span i {
            font-size: 40px;
            color: #00AEEF;
        }

        .contact-us span i {
            margin: auto
        }

        .form2_level strong {
            font-size: 24px;
            font-weight: 700;
            color: #666;
            margin-top: 16px;
        }


        #step-1 {
            margin-right: -16px;
        }

        .radio-group {
            display: -webkit-inline-box;
            flex-direction: column;
            gap: 10px;
        }

        .radio-group label {
            display: inline-block;
            align-items: center;
        }

        .radio-group input[type="radio"] {
            display: none;
        }

        .radio-group .radio-icon {
            margin-right: 10px;
            font-size: 1.5rem;
        }

        .radio-group input[type="radio"]:checked + .radio-icon {
            color: #007bff; /* Change the color as needed */
        }

        .file-input__label svg {
            height: 16px;
            margin-right: 4px;
        }

        .form-check-inline {
            display: -webkit-inline-box;
        }

        /* responsive */

        @media (max-width: 1199px) {


            .card-title {

                font-size: 19px;
            }


            .form2_level strong {
                font-size: 21px;
            }
        }

        @media (max-width: 991px) {


            .form-control {
                height: calc(1.6em + 0.75rem + 2px);
            }

            .form2_level strong {
                font-size: 18px;
            }


            .contact-us span {
                font-size: 18px;
            }
        }

        @media (max-width: 767px) {


            #step-1::before {
                content: none;

            }


        }

        @media (max-width: 575px) {


            .contact_icon_div i {
                margin: 5px !important;
            }


        }


        @media (max-width: 430px) {


            .form-control {
                width: 100%;
                height: calc(1.6em + 0.75rem + 2px);
            }
        }


    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card" style="border:none;">
                    <div class="card-body">
                        <div class="row ">

                            <div class="col-md-12">

                                <form id="laptopexchangeform" action="{{route('user.storeUpgrade')}}"
                                      method="post" encType="multipart/form-data">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                                    <input type="hidden" name="deal_type" value="{{$dealType}}"/>


                                    <div class=" card  setup-content" id="step-1">
                                        <div
                                                class="card-header bg-exchange cart_head_div pt-4 font-weight-bold shadow">
                                            <h2 class="justify-content-center text-center  pl-2 pr-2 pb-2 m text-black"
                                                style="border-radius: 5px; color: #454241; margin: 13px 13px 0px 13px;">
                                                প্রয়োজনীয় তথ্য দিন
                                            </h2>
                                        </div>
                                        <div class="card-body bg-exchange form_card-body ">
                                            <h6 class=" text-center p-2" style="font-weight: normal"
                                                for="product"><strong>{{ucfirst($dealType)}} or Repair Your
                                                    Device</strong></h6>
                                            @if($catId != 0)
                                                <div class="row mt-2">
                                                    <div class="form_input">
                                                        <span class="form-control form-input">{{$category->name}}</span>
                                                        <input type="hidden" name="product" value="{{$catId}}">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row mt-1">
                                                    <div class="form_input">
                                                        {!! Form::select('product',[''=>'Select product']
                                                          +$category,old('product'), $attributes =
                                                          array('class'=>'js-example-basic-single form-control
                                                          form-input
                                                          required','required',
                                                          'id'=>"product")) !!}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row mt-1">
                                                <div class="form_input">
                                                    {!! Form::select('brand',[''=>'Select Brand']
                                                    +$brand,isset($selectedData['brand'])?$selectedData['brand']:old('brand'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required','required',
                                                    'id'=>"brand")) !!}
                                                </div>
                                            </div>
                                            @if($catId !=3)
                                                <div class="row mt-1">
                                                    <div class="form_input">
                                                        <input type="text" class="form-control form-input"
                                                               id="model" placeholder="Write Model (optional)"
                                                               name="model" value="{{$selectedData['model']??''}}"
                                                               />
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row mt-1">
                                                <div class="form_input">
                                                    <textarea class="form-control required form-input"
                                                              placeholder="Write service or upgrade note"
                                                              name="upgrade_note"></textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <h3 class="font-weight-bold">Customer Information</h3>
                                            <div class="row mt-1">
                                                <div class="form_input">
                                                    <input type="text" name="username" placeholder="Full Name"
                                                           class="form-control rounded required form-input"
                                                           required
                                                           id="username"/>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="form_input">
                                                    <input class="form-control form-input required rounded" type="text"
                                                           id="phone"
                                                           name="mobileno"
                                                           placeholder="Phone Number"
                                                           maxlength="11">
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="form_input">
                                                    <input type="email" placeholder="Email (optional)" name="email"
                                                           class="form-control form-input"
                                                           id="inputEmail"/>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <h4 class="font-weight-bold">Location / Delivery Option</h4>
                                            <div class="row mt-1">
                                                <div class="form_input radio-group">
                                                    <label class="form-check-inline">
                                                        <input type="radio" class="required delivery_method" checked name="service_from"
                                                               value="outlet">
                                                        <span class="radio-icon"><i class="fa fa-shop"></i></span>
                                                        Service From Outlet
                                                    </label>
                                                    <label class="form-check-inline">
                                                        <input type="radio" class="required delivery_method" name="service_from"
                                                               value="home">
                                                        <span class="radio-icon"><i class="fas fa-home"></i></span>
                                                        Home/Office Service
                                                    </label>

                                                </div>
                                            </div>

                                            <div class="row mt-1" id="store_pickup">
                                                @if(!empty($storeAddresses))
                                                    @foreach ($storeAddresses as $office)
                                                        <label class="office-option ml-4 p-3 mt-2 rounded" style="border: 1px solid #8d9690; width: 100%;">
                                                            <input type="radio" name="selected_office" value="{{ $office['name'] }}" required style="margin-right: 10px;">
                                                            <span><strong>{{ $office['name'] }}</strong></span><br>
                                                            <span>{{ $office['address'] }}</span>
                                                        </label>
                                                    @endforeach
                                                @else
                                                    <p>No stores available at the moment.</p>
                                                @endif
                                            </div>
                                            <div id="home_delivery" class="row mt-1" style="display: none">
                                                <div class="form_input">
                                                    <textarea class="form-control form-input required"
                                                              placeholder="Address Line*"
                                                              name="address_line"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mt-1" hidden="">
                                                <div class="form_input">
                                                    {!! Form::select('city',[''=>'Select City'] +$city,'', $attributes = array('class'=>'js-example-basic-single form-control form-input required',
                                                               'id'=>"city")) !!}
                                                </div>
                                            </div>
                                            <div class="row mt-1" hidden="">
                                                <div class="form_input">
                                                    {!! Form::select('thana',[''=>'Select City'],'', $attributes = array('class'=>'js-example-basic-single form-control form-input required',
                                                                    'id'=>"thana")) !!}
                                                </div>
                                            </div>
                                            <div class=" mt-5 text-center ">
                                                <button class="btn btn-primary btn-lg" style="padding: 4px 18px;"
                                                        id="finalsubmit" type="submit">Submit
                                                </button>
                                            </div>
                                        </div>
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
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>

    <script type="text/javascript">
        $(".delivery_method").on('click',function (e){
            let method = $(this).val();
            if(method == 'home'){
                $("#store_pickup").hide();
                $("#home_delivery").show();
            }else{
                $("#home_delivery").hide();
                $("#store_pickup").show();
            }
        })
        $(document).ready(function () {

            $("#city").on("change", function () {
                let cityid = $(this).val();
                $.ajax({
                    url: '/info/get-thana/' + cityid,
                    type: "GET",
                    success: function (response) {
                        var option = '<option value="">Select One</option>';
                        $.each(response, function (key, row) {
                            option += '<option selected="true" value="' + row.id + '">' + row.display + '</option>';
                        });
                        $("#thana").html(option)
                    }
                });
            });
        });
        $('#frontimage').change(function () {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    console.log(event.target.result);
                    $('#fontImagePreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });

        $('#backimage').change(function () {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    console.log(event.target.result);
                    $('#backImagePreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });


        $('#laptopexchangeform').validate({
            errorPlacement: function () {
                return true;
            }
        });
    </script>
@endsection