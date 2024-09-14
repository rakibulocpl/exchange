@extends('layouts.admin')

@section('content')
    <style>
        .product-info-table tbody {
            display: flex;
            flex-wrap: wrap;
        }
        .product-info-table tbody tr {
            margin: 0 7px 7px -2px;
            background: rgba(55,73,187,.05);
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
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header bg-inverse-primary">{{ $product->product_name }}</div>
                    <div class="card-body">
                        <div class="card-body">
                            <h3 class="text-primary">Product Code : {{$product->product_code}}</h3>
                            <div class="row">
                                <input type="hidden" value="{{$product->id}}" name="product_id" id="product_id">
                                <div class="col-md-5">
                                    <img class="img-thumbnail" src="{{asset($product->thumbnail)}}" alt="{{$product->product_name}}"/>
                                </div>
                                <div class="col-md-7">
                                    <h5 class="font-weight-semibold mb-2">
                                <span  class="text-primary mb-2"
                                       data-abc="true">{{$product->product_name}}</span>
                                        <table class="product-info-table">
                                            <tbody>
                                            <tr class="product-info-group">
                                                <td class="product-info-label">Price</td>
                                                <td class="product-info-data product-price">{{$product->price}}৳</td>
                                            </tr>
                                            <tr class="product-info-group">
                                                <td class="product-info-label">Product Code</td>
                                                <td class="product-info-data product-code">{{$product->product_code}}</td>
                                            </tr>
                                            <tr class="product-info-group" itemprop="brand" itemtype="http://schema.org/Thing"
                                                itemscope="">
                                                <td class="product-info-label">Brand</td>
                                                <td class="product-info-data product-brand" itemprop="name">{{$product->brand->name}}</td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </h5>
                                    <h2>Key Features</h2>
                                    <div class="short-description text-left">
                                        {!! $product->short_description !!}
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <h3> Full Specification</h3>
                                    <hr>
                                    <div class="text-left">
                                        {!! $product->description !!}
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