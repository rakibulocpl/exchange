@extends('layouts.user')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
<style>
    .short-description li {
        font-size: 13px;
        color: #666;
        position: relative;
        line-height: 16px;
        padding-bottom: 10px;
    }

    .bg-cart {
        background-color: orange !important;
        color: #fff !important;
    }

    hr {
        margin: 5px !important;
    }

    .product-info-table tbody {
        display: flex;
        flex-wrap: wrap;
    }

    .product-info-table tbody tr {
        margin: 0 7px 7px -2px;
        background: rgba(55, 73, 187, .05);
        border-radius: 30px;
        line-height: 30px;
        padding: 0 10px;
        font-size: 14px;
    }

    .product-info-table tbody tr .product-info-label {
        color: #666;
    }

    .product-info-table tbody tr .product-info-label:after {
        content: ":";
    }

    .product-info-table tbody tr .product-info-data {
        font-weight: bold;
        font-size: 14px;
    }

    .radio-group {
        display: -webkit-inline-box;
        flex-direction: column;
        gap: 10px;
    }

    .radio-group label {
        display: flex;
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
</style>
@section('content')
    <div class="container">
        <div class="col-md-12 p-2">
            <div class="card">
                <div class="card-body bg-exchange">
                    <h2 class="text-center border-bottom">Buy Product</h2>
                    <form id="checkoutForm" action="{{route('user.checkout')}}"
                          method="post" encType="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                        <div class="card card-small" style="margin: 0 auto;">
                            <div class="card-body">
                                <h4>My Cart</h4>
                                <div class="products">
                                    @foreach($cart as $key =>$value)
                                        <input type="hidden" name="product_id[]" value="{{$value['id']}}">
                                        <div class="row mt-2">
                                            <div class="col-md-5">
                                                <img class="img-thumbnail"
                                                     src="{{asset($value['thumbnail'])}}"
                                                     alt=""/>
                                            </div>
                                            <div class="col-md-7">
                                            <span class="text-muted mb-2"
                                                  data-abc="true">{{$value['name']}}</span>
                                                <br>
                                                <span class="text-primary bg-youtube"
                                                      data-abc="true">Price: {{$value['price']}}</span>
                                                <a class="btn  btn-danger ml-2" href="{{route('user.removeItem',[$key])}}"><i class="fa fa-remove" ></i> </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        <div class="card card-small bg-exchange" style="margin: 0 auto;">
                            <div class="card-body">
                                <h4 class="font-weight-bold">Customer Information</h4>
                                <div class=" mt-1">
                                    <div class="form_input">
                                        <input type="text" name="username" placeholder="Full Name"
                                               class="form-control rounded required form-input"
                                               required
                                               id="username"/>
                                    </div>
                                </div>
                                <div class=" mt-1">
                                    <div class="form_input">
                                        <input class="form-control form-input bd_mobile required rounded" type="text"
                                               id="phone"
                                               name="mobileno"
                                               placeholder="Phone Number"
                                               maxlength="11">
                                    </div>
                                </div>
                                <div class=" mt-1">
                                    <div class="form_input">
                                        <input type="email" placeholder="Email" name="email"
                                               class="form-control form-input required"
                                               id="email"/>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <h4 class="font-weight-bold">Location / Delivery option</h4>
                                <div class=" mt-1">
                                    <div class="form_input">
                                        <div class="form_input radio-group">
                                            <label class="form-check-inline ">
                                                <input type="radio" class="required delivery_method"  checked name="service_from" value="outlet">
                                                <span class="radio-icon "><i class="fa fa-shop"></i></span>
                                                Store Pickup
                                            </label>
                                            <label class="form-check-inline ">
                                                <input type="radio"  class="required delivery_method" name="service_from" value="home">
                                                <span class="radio-icon "><i class="fas fa-home"></i></span>
                                                Home Delivery
                                            </label>

                                        </div>
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


                                <div id="home_delivery" style="display: none">
                                    <div class=" mt-1">
                                        <div class="form_input">
                                            {!! Form::select('city',[''=>'Select Area'] +$city,'', $attributes = array('class'=>'js-example-basic-single form-control form-input required',
                                                       'id'=>"city")) !!}
                                        </div>
                                    </div>

                                    <div class=" mt-1">
                                        <div class="form_input">
                                    <textarea class="form-control form-input required" placeholder="Address Line*"
                                              name="address_line"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class=" mt-3 text-center ">
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
@endsection
@section('footer-script')
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>

    <script>
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
        jQuery.validator.addMethod("validate_email", function (value, element) {

            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "Please enter a valid Email.");
        $("#checkoutForm").validate({
            errorPlacement: function () {
                return true;
            }, rules: {
                email: {
                    validate_email: true
                }
            }
        });
    </script>

@endsection