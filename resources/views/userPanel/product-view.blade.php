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

    .selected-image {
        border: 2px solid #007bff;
    }

    .category-box {
        padding: 5px;
        text-align: center;
        margin-bottom: 20px;
        border-radius: 16px;
        box-shadow: 2px 2px 2px 2px rgb(140, 148, 151,1);
    }
    .category-box img {
        height: 80px;
        width: 80px;
        background-size: cover;
        border-radius: 5px;
        background: white;
    }
    .category-box:hover {
        background: #27A7DF;
        color: white;
    }
    .category-box a {
        text-decoration: none;
        color: black;
    }
    .category-list-box {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
</style>
@section('meta_title',!empty($product->meta_title)?$product->meta_title:$product->product_name)
@section('meta_description', !empty($product->meta_description)?$product->meta_description:$product->product_name)
@section('content')
    <div class="container">
        <div class="col-md-12 p-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" value="{{$product->id}}" name="product_id" id="product_id">
                        <div class="col-md-5">
                            <img class="img-thumbnail lazyload" id="product_thumbnail" data-src="{{asset($product->thumbnail)}}" src="{{asset('img/default-site-img.png')}}"  loading="lazy"  alt="{{$product->product_name}}"  onerror="this.src=`{{asset('img/default-site-img.png')}}`"/>
                            <div class="col-md-12 category-list-box mt-2">
                                @foreach($images as $image)
                                    <div class="category-box" onclick="changeImage(this)">
                                        <img  data-src="{{!empty($image->path)?'/'.$image->path:'/img/blog/1.jpg'}}" src="{{asset('img/default-site-img.png')}}" class="lazyload" loading="lazy"  onerror="this.src=`{{asset('img/default-site-img.png')}}`"  alt="Category Image">
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-md-7">
                            <h4 class="font-weight-semibold mb-2">
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

                            </h4>
                            <h2>Key Features</h2>
                            <div class="short-description text-left">
                                {!! $product->short_description !!}
                            </div>
                            <div class="text-left">
                                <button type="button" class="btn bg-cart bg-primary m-2" id="buy_now">
                                    <i class="fa fa-cart-plus mr-2"></i>
                                    Buy Now
                                </button>
                                @if(session()->has('dealId'))
                                    <button type="button" class="select-exchange btn btn-secondary m-2"
                                            data-product="{{$product->id}}">
                                        <i class="fa fa-exchange-alt mr-2"></i> Select for Exchange
                                    </button>
                                @endif
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
@endsection
@section('footer-script')

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://www.elevateweb.co.uk/wp-content/themes/radial/jquery.elevatezoom.min.js"></script>
    <script>
        $("#buy_now").on('click', function () {
            let productId = $("#product_id").val();
            $.ajax({
                url: "{{route('user.addToCart')}}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    product_id: productId
                },
                success: function (response) {
                    if (response.responseCode == 1) {
                        window.location.href = '/checkout/cart';
                    } else if (response.responseCode == -1) {
                        alert(response.message);
                    }
                }
            });
        });
        function changeImage(thumbnail) {
            // Remove the 'selected-image' class from all thumbnails
            const thumbnails = document.querySelectorAll('.category-box');
            thumbnails.forEach(t => t.classList.remove('selected-image'));

            // Add the 'selected-image' class to the clicked thumbnail
            thumbnail.classList.add('selected-image');

            // Change the source of the selected image
            const selectedImage = document.getElementById('product_thumbnail');
            selectedImage.src = thumbnail.querySelector('img').src;
        }
    </script>


@endsection