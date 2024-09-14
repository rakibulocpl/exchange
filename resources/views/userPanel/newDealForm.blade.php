@extends('layouts.user')

@section('content')
    {{--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-index: 0;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }

        .form_input {
            width: 98%;
            margin-left: 20px;
            margin-right: 50px;
        }


        .category-img {
            height: 100%;
            width: 100%;
        }

        .strong {
            font-weight: 500;
            font-size: 18px;
            margin-left: 3rem;
        }

        .card-title {
            color: #56a7f7;
            font-weight: bold;
            font-size: 21px;
        }

        .Cart_input_color {
            background-color: #f0f0f0;
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

        .contact_left_heading {
            margin: 20px 0;
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

        /* .form_card-body {
            overflow: auto;
        } */

        .form_card {
            height: 728px;
        }

        .form2_level strong {
            font-size: 18px;
            font-weight: 700;
            color: #666;
            margin-top: 16px;
        }

        .row.form2_options.ml-5 {
            font-size: 16px;
        }


        .step2_h1 {
            font-weight: bolder;
            font-size: 28px;
        }


        .row.form_main_row {
            border: 1px solid #ece7e7;
            margin: 1px;
            border-radius: 9px;
        }

        #step-1 {
            margin-right: -16px;
        }

        #step-3 {
            margin-right: -16px;
        }

        .contact_icon {
            font-size: 36px;
            color: #00AEEF;
        }

        .file-input__input {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .file-input__label {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            font-size: 14px;
            padding: 10px 12px;
            background-color: #4245a8;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.25);
        }

        .file-input__label svg {
            height: 16px;
            margin-right: 4px;
        }

        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            display: none;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -60px;
            margin-top: -60px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }



    </style>
    <div class="container">
        <div id="loader" class="loader-container">
            <div class="loader"></div>
        </div>
        <div id="message"></div>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card" style="border:none;">
                    <div class="card-body">
                        <div class="stepwizard" style="display: none">
                            <div class="stepwizard-row setup-panel">
                                <div class="stepwizard-step col-xs-3">
                                    <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                                    <p><small>Step 1</small></p>
                                </div>
                                <div class="stepwizard-step col-xs-3">
                                    <a href="#step-2" type="button" class="btn btn-default btn-circle"
                                       disabled="disabled">2</a>
                                    <p><small>Step 2</small></p>
                                </div>
                                <div class="stepwizard-step col-xs-3">
                                    <a href="#step-3" type="button" class="btn btn-default btn-circle"
                                       disabled="disabled">3</a>
                                    <p><small>Step 3</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="row ">

                            <div class="col-md-12">
                                <form id="laptopexchangeform" action="{{route('user.newstore')}}"
                                      method="post" encType="multipart/form-data">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                                    <input type="hidden" name="deal_type" value="{{$dealType}}"/>


                                    <div class=" card  setup-content" id="step-1">
                                        <div
                                                class="card-header bg-exchange cart_head_div pt-4 font-weight-bold shadow">
                                            <h3 class="card-title text-white bg-primary p-1 text-center ml-2"
                                                style="border-radius: 5px;">আপনার পুরোনো ডিভাইসের তথ্য দিন</h3>
                                        </div>
                                        <div class="card-body bg-exchange form_card-body pt-0">
                                            <h3 class=" text-center p-2"><strong>{{ucfirst($dealType)}}</strong></h3>
                                            @if($catId != 0)
                                                <div class="mt-2">
                                                    <div class="form_input">
                                                        <span class="form-control">{{$category->name}}</span>
                                                        <input type="hidden" id="product" name="product" value="{{$catId}}">
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mt-2">
                                                    <div class="form_input ">
                                                        {!! Form::select('product',[''=>'Select Product']
                                                  +$category,old('product'), $attributes =
                                                  array('class'=>'js-example-basic-single form-control form-input required','required','id'=>"product",'required' )) !!}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-1">
                                                <div class="form_input">
                                                    {!! Form::select('brand',[''=>'Select Brand']
                                                    +$brand,isset($selectedData['brand'])?$selectedData['brand']:old('brand'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required','required',
                                                    'id'=>"brand")) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <div class="form_input">
                                                    <input type="text" class="form-control form-input required"
                                                           id="model" placeholder="Write Model (Optional)"
                                                           name="model" value="{{$selectedData['model']??''}}"
                                                    />
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <div class="form_input">
                                                    {!! Form::select('processor',[''=>'Processor']
                                                    +$allComponents['Processor'],old('processor'),
                                                    $attributes =
                                                    array('class'=>'js-example-basic-single form-input
                                                    form-control
                                                    required',
                                                    'id'=>"processor",'required')) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <div class="form_input">
                                                    {!! Form::select('ram',[''=>'RAM']
                                                    +$allComponents['Ram'],old('ram'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required',
                                                    'id'=>"ram",'required')) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1 ">
                                                <div class="form_input">
                                                    {!! Form::select('storage',[''=>'Storage']
                                                    +$allComponents['Storage'],old('storage'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required',
                                                    'id'=>"storage",'required')) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1 onlyLaptop">
                                                <div class="form_input">
                                                    {!! Form::select('display',[''=>'Display']
                                                    +$allComponents['Display'],old('display'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required',
                                                    'id'=>"display",'required')) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <div class="form_input">
                                                    {!! Form::select('graphics',[''=>'Graphics Card']
                                                    +$allComponents['Graphics'],old('graphics'), $attributes
                                                    =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required',
                                                    'id'=>"graphics",'required')) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1 onlyDesktop">
                                                <div class="form_input">
                                                    {!! Form::select('monitor_brand',[''=>'Monitor Brand (Optional)']
                                                    +$allComponents['Monitor'],isset($selectedData['monitor_brand'])?$selectedData['monitor_brand']:old('monitor_brand'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input',
                                                    'id'=>"monitor_brand")) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1 onlyDesktop">
                                                <div class="form_input">
                                                    {!! Form::select('monitor_size',[''=>'Monitor Size (optional)']
                                                    +$allComponents['MonitorSize'],isset($selectedData['monitor_size'])?$selectedData['monitor_size']:old('monitor_size'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input',
                                                    'id'=>"monitor_size")) !!}
                                                </div>
                                            </div>
                                            <div class="mt-1 onlyLaptop">
                                                <div class="form_input">

                                                    {!! Form::select('battery',[''=>'Battery Backup']
                                                    +$allComponents['Battery'],old('battery'), $attributes =
                                                    array('class'=>'js-example-basic-single form-control
                                                    form-input
                                                    required',
                                                    'id'=>"battery",'required')) !!}
                                                </div>
                                            </div>

                                            <div class=" text-muted mx-5 mt-4 text-center">
                                                <button class="btn btn-primary nextBtn" type="button"
                                                        style="background: transparent;color: #666; padding: 4px 18px; ">
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="card  panel-primary setup-content" id="step-2">
                                        <div class="card-header bg-exchange   pt-4 shadow-sm ">
                                            <h3 class="card-title text-center text-white bg-primary p-1 ml-5"
                                                style="border-radius: 5px;">পুরোনো ডিভাইসের কন্ডিশন ?</h3>
                                        </div>
                                        <div class="card-body form_card-body bg-exchange  pt-0">
                                            <h3 class=" text-center p-2" for="product">
                                                <strong>{{ucfirst($dealType)}}</strong></h3>

                                            <h1 class="font-bold step2_h1" style="margin-left: 30px">Product
                                                Condition</h1>
                                            <div>
                                                <label class="row text-left form2_level"
                                                       for="processorstatus"><strong class="strong">Device
                                                        Power</strong> </label>

                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" type="radio"
                                                                   name="laptoppower" required value="running"/>
                                                            Running
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" type="radio"
                                                                   required name="laptoppower" value="dead"/>
                                                            Dead
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="row text-left form2_level"
                                                       for="processorstatus"><strong class="strong">Processor
                                                        Status</strong> </label>
                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" type="radio"
                                                                   required name="processorstatus" value="working"/>
                                                            Working
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" type="radio"
                                                                   required name="processorstatus" value="trouble"/>
                                                            Trouble
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>

                                                <label class="row text-left form2_level" for="storagestatus"><strong
                                                            class="strong">Storage Status</strong> </label>

                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio" name="storagestatus" value="working"/>
                                                            Working
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="storagestatus" value="trouble"/>
                                                            Trouble
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="row text-left form2_level" for="ramstatus"><strong
                                                            class="strong">RAM
                                                        Status</strong> </label>

                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="ramstatus" value="working"/>
                                                            Working
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input required" type="radio"
                                                                   name="ramstatus" value="trouble"/>
                                                            Trouble
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="displaystatus" class="onlyLaptop">
                                                <label class="row text-left form2_level" for="displaystatus"><strong
                                                            class="strong">Display
                                                        Status</strong> </label>

                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="displaystatus" value="working"/>
                                                            Running
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="displaystatus" value="trouble"/>
                                                            No Display
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="displaystatus" value="broken"/>
                                                            Display Broken
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="row text-left form2_level"
                                                       for="graphicsstatus"><strong class="strong">Graphics
                                                        Card </strong></label>
                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="graphicsstatus" value="working"/>
                                                            Working
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="graphicsstatus" value="trouble"/>
                                                            Trouble
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="physicalstatus" class="onlyLaptop">
                                                <label class="row text-left form2_level"
                                                       for="physicalstatus"><strong class="strong">Physical
                                                        Condition</strong>
                                                </label>

                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   name="physicalstatus" type="radio"
                                                                   value="fullfresh"/>
                                                            Full Fresh
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="physicalstatus" value="broken"/>
                                                            Normal Broken
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input form-input" required
                                                                   type="radio"
                                                                   name="physicalstatus" value="scratch"/>
                                                            scratch
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <label class="row text-left form2_level" for="morecondition">
                                                    <strong class="strong"> More condition More condition </strong>
                                                </label>
                                                <div class="row form2_options ml-5">
                                                    <div class="form-check form-check-inline">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="more_condition[]" value="USB Not working"/>
                                                            USB Not working
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline onlyLaptop">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input " type="checkbox"
                                                                   name="more_condition[]" value="Web Cam Not Working"/>
                                                            Web Cam Not Working
                                                        </label>
                                                    </div>


                                                    <div class="form-check form-check-inline onlyLaptop">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="more_condition[]" value="Touch Pad Not Working"/>
                                                            Touch Pad Not Working
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline onlyLaptop">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="more_condition[]" value="Key board Problem"/>
                                                            Key board Problem
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline onlyLaptop">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="more_condition[]" value="No Charging Issue"/>
                                                            No Charging Issue
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline onlyDesktop">

                                                        <label class="form-check-label">
                                                            <input class="form-check-input " type="checkbox"
                                                                   name="more_condition[]" value="UPS Available"/>
                                                            UPS Available
                                                        </label>
                                                    </div>


                                                    <div class="form-check form-check-inline onlyDesktop">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="more_condition[]" value="Audio Not Working"/>
                                                            Audio Not Working
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group my-4">
                                                <div class="row">

                                                    <div class="col-md-6  p-2 file-input text-center">
                                                        <input type="file" name="frontimage" id="frontimage"
                                                               class="form-control required upload-image-front form-input file-input__input" required />
                                                        <label class="file-input__label" for="frontimage">
                                                            <svg
                                                                    aria-hidden="true"
                                                                    focusable="false"
                                                                    data-prefix="fas"
                                                                    data-icon="upload"
                                                                    class="svg-inline--fa fa-upload fa-w-16"
                                                                    role="img"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512"
                                                            >
                                                                <path
                                                                        fill="currentColor"
                                                                        d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"
                                                                ></path>
                                                            </svg>
                                                            <span>Upload Photo 1</span></label>
                                                        <input type="hidden" name="front_image_path" id="front_image_path">

                                                        <br/>

                                                        <input name="backimage" type="file" id="backimage"
                                                               class="form-control required form-input upload-image-back file-input__input" required/>
                                                        <label class="file-input__label" for="backimage">
                                                            <svg
                                                                    aria-hidden="true"
                                                                    focusable="false"
                                                                    data-prefix="fas"
                                                                    data-icon="upload"
                                                                    class="svg-inline--fa fa-upload fa-w-16"
                                                                    role="img"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 512 512"
                                                            >
                                                                <path
                                                                        fill="currentColor"
                                                                        d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"
                                                                ></path>
                                                            </svg>
                                                            <span>Upload Photo 2</span></label>
                                                        <input type="hidden" name="back_image_path" id="back_image_path">

                                                    </div>
                                                    <div class="col-md-6 p-2 text-center">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <img  data-laptop="{{asset('images/samples/laptop_sample_1.jpeg')}}"
                                                                      data-desktop="{{asset('images/samples/monitor.jpg')}}"
                                                                      src="{{asset('images/samples/laptop_sample_1.jpeg')}}"
                                                                        class="img-fluid" alt="Font image"
                                                                        id="fontImagePreview"
                                                                        width="307"
                                                                        style="max-height: 120px !important;"/>

                                                            </div>
                                                            <div class="col-6">
                                                                <img data-laptop="{{asset('images/samples/laptop_sample_2.jpeg')}}"
                                                                     data-desktop="{{asset('images/samples/desktop.jpg')}}"
                                                                         src="{{asset('images/samples/laptop_sample_2.jpeg')}}"
                                                                     class="img-fluid" alt="Font image"
                                                                     id="backImagePreview"
                                                                     width="307" style="max-height: 120px !important;"/>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class=" text-muted text-center">
                                                <button class="btn btn-success previousBtn"
                                                        style="margin-right:10px; background: transparent; color: #666; padding: 4px 18px;"
                                                        type="button">Previous
                                                </button>
                                                <button class="btn btn-primary nextBtn " type="button"
                                                        style="background: transparent;color: #666; padding: 4px 18px;">
                                                    Next
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card   setup-content bg-exchange" id="step-3" style="margin:0 auto">
                                        <div class="card-body">
                                            @auth
                                                <div class=" text-center " id="userInfo">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="required-star col-md-3" for="username">NAME
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="username"
                                                                       value="{{\Illuminate\Support\Facades\Auth::user()->name}}"
                                                                       class="form-control rounded form-input"
                                                                       required
                                                                       id="username"/>
                                                                <div id="fname_error" class="val_error"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="inputEmail col-md-3">EMAIL</label>
                                                            <div class="col-md-9">
                                                                <input type="email"
                                                                       value="{{\Illuminate\Support\Facades\Auth::user()->email}}"
                                                                       class="form-control form-input" name="email"
                                                                       id="inputEmail"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="city"
                                                                   class="required-star  col-md-3">City
                                                            </label>
                                                            <div class="col-md-9">
                                                                {!! Form::select('city',[''=>'Select City']
                                                                +$city,\Illuminate\Support\Facades\Auth::user()->city,
                                                                $attributes =
                                                                array('class'=>'js-example-basic-single form-control
                                                                form-input',
                                                                'id'=>"city",'required')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endauth
                                            @guest
                                                <div class=" text-center col-md-6 bg-exchange" style="margin: 0 auto;"
                                                     id="mobileVerification">
                                                    <strong>User Information</strong>
                                                    <div class="form-group">
                                                        <div id="otp" class="inputs justify-content-center mt-1">
                                                            <input class="  form-control rounded" type="text"
                                                                   id="phone"
                                                                   name="mobileno"
                                                                   placeholder="Enter your Phone Number"
                                                                   maxlength="11"><br>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 ">
                                                        <button type="button" id="verifyBtn"
                                                                class="btn btn-primary btn-sm">
                                                            {{ __('Verify') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class=" text-center" id="mobileValidation"
                                                     style="display: none">
                                                    <h4>Please enter the OTP<br></h4>
                                                    <div>
                                                        <span> sent to</span> <small id="mobileview"></small>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-12 ">
                                                            <input type="hidden" id="registerStatus"
                                                                   name="registerStatus"/>
                                                            <input class="m-2 text-center rounded " type="text"
                                                                   id="input1"
                                                                   name="otp" placeholder="****"
                                                                   style="width: 150px"
                                                                   autoFocus/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-12 ">
                                                            <button type="button" id="validationButton"
                                                                    class="btn btn-primary">
                                                                {{ __('Confirm') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" text-center bg-exchange" id="userInfo"
                                                     style="display: none">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="required-star col-md-3" for="username">NAME
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="username"
                                                                       class="form-control rounded form-input"
                                                                       required
                                                                       id="username"/>
                                                                <div id="fname_error" class="val_error"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="inputEmail col-md-3">EMAIL</label>
                                                            <div class="col-md-9">
                                                                <input type="email" name="email"
                                                                       class="form-control form-input"
                                                                       id="inputEmail"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label for="city"
                                                                   class="required-star text-left col-md-3">City
                                                            </label>
                                                            <div class="col-md-9">
                                                                {!! Form::select('city',[''=>'Select City'] +$city,'',
                                                                $attributes =
                                                                array('class'=>'js-example-basic-single form-control
                                                                form-input',
                                                                'id'=>"city",'required')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endguest

                                        </div>
                                        <div class=" text-muted">

                                        </div>

                                        <div class=" text-muted text-center">
                                            <button class="btn btn-success previousBtn"
                                                    style="margin-right:10px; background: transparent; color: #666; padding: 4px 18px;"
                                                    type="button">Previous
                                            </button>
                                            <button class="btn btn-primary btn-sm" style="padding: 4px 18px;" @guest
                                                hidden @endguest id="finalsubmit" type="submit">Submit
                                            </button>
                                        </div>
                                        <br>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/js/uploader.js"></script>
    <script type="text/javascript">
        const frontPartUpload = new ImageUploader('.upload-image-front', '#message', '#loader', '#front_image_path', '#fontImagePreview', 5, ['image/jpeg', 'image/png']);
        const backPartUpload = new ImageUploader('.upload-image-back', '#message', '#loader', '#back_image_path', '#backImagePreview', 5, ['image/jpeg', 'image/png']);


        $("#verifyBtn").on('click', function () {
            let mobileNo = $("#phone").val();
            let pattern = '/^(?:\\+88|01)?(?:\\d{11}|\\d{13})$/';
            $.ajax({
                url: "{{route('user.sendotp')}}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    mobileno: mobileNo
                },
                success: function (response) {
                    if (response.responseCode == 1) {
                        $("#mobileview").text(mobileNo);
                        $("#mobileVerification").hide();
                        $("#mobileValidation").show();
                        $("#registerStatus").val(response.registerStatus)
                    } else if (response.responseCode == -1) {
                        alert(response.message);
                    }
                }
            });
        });
        $("#finalsubmit").on('click', function () {
            $(this).closest('form').submit();
            $(this).prop('disabled', true);
            $(this).text("Processing...");
        });
        $("#validationButton").on('click', function () {
            let mobileNo = $("#phone").val();
            let otp = $("#input1").val()
            let registerStatus = $("#registerStatus").val();
            let pattern = '/^(?:\\+88|01)?(?:\\d{11}|\\d{13})$/';
            $.ajax({
                url: "{{route('user.verifyOtp')}}",
                type: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    mobileno: mobileNo,
                    isRegiter: registerStatus,
                    otp: otp,
                },
                success: function (response) {
                    if (response.status == 1) {
                        $("#mobileValidation").remove();
                        $("#mobileVerification").remove();
                        $("#username").val(response.user.name);
                        $("#city").val(response.user.city);
                        $("#inputEmail").val(response.user.email);
                        $("#finalsubmit").removeAttr('hidden');
                        $("#userInfo").show();
                    } else if (response.status == -1) {
                        alert(response.message);
                    }
                }
            });
        });
        $(document).ready(function () {

            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn'),
                allPreviousBtn = $('.previousBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-success').addClass('btn-default');
                    $item.addClass('btn-success');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allPreviousBtn.click(function () {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    previousStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev()
                        .children("a");
                previousStepWizard.trigger('click');
            });

            allNextBtn.click(async function () {

                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next()
                        .children("a"),
                    curInputs = curStep.find(
                        "input[type='text'],input[type='checkbox'],input[type='radio'],input[type='url'],input[type='file'],select"
                    ),
                    isValid = true;


                $(".form-input").removeClass("error");
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-input").addClass("error");
                        $(curInputs[i]).next("label").addClass("error");
                    }
                }

                if (isValid && curStepBtn == 'step-1') {
                    if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');

                } else {
                    if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
                }

            });

            $('div.setup-panel div a.btn-success').trigger('click');
        });

        $("#product").on('change',function (e){
            let product = $(this).val();
            if(product == 2){
                $('.onlyLaptop').show();
                $('.onlyDesktop').hide();
                $('.onlyDesktop').find('.form-input').removeAttr('required');
                let onlyLaptopsInput = $('.onlyLaptop').find('.form-input');
                $.each(onlyLaptopsInput,function (key,row){
                    if($(row).hasClass('required') == true){
                        $(row).prop('required',true);
                    }
                });
                let frontImage = $('#fontImagePreview').attr('data-laptop');
                let backImage = $('#backImagePreview').attr('data-laptop');
                $('#fontImagePreview').attr('src',frontImage);
                $('#backImagePreview').attr('src',backImage);

            }else if(product == 3){
                $('.onlyLaptop').hide();
                $('.onlyDesktop').show();
                $('.onlyLaptop').find('.form-input').removeAttr('required')
                let onlyLaptopsInput = $('.onlyDesktop').find('.form-input');
                $.each(onlyLaptopsInput,function (key,row){
                    if($(row).hasClass('required') == true){
                        $(row).prop('required',true);
                    }
                });
                let frontImage = $('#fontImagePreview').attr('data-desktop');
                let backImage = $('#backImagePreview').attr('data-desktop');
                $('#fontImagePreview').attr('src',frontImage);
                $('#backImagePreview').attr('src',backImage);
            }
        });
        $("#product").trigger('change')
    </script>
@endsection