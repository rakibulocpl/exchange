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

    .p-item {
        display: flex;
    }

    .product-details {
        display: flex;
        flex-direction: column;
    }
</style>
@if(isset($category))
    @section('meta_title',$category->meta_title)
    @section('meta_description', $category->meta_description)
@endif

@section('content')
    <div class="container">

        <div class="col-md-12">
            <div class="card" style="border: none">
                @if(isset($category))
                    <div class="card-body text-center">
                        <h4> {{$category->name}}</h4>
                    </div>
                @else
                    <div class="card-body text-center">
                        <h4> Product Gallery</h4>
                    </div>
                @endif

            </div>
        </div>
        <div >
            <div class="card" style="border: none">
                <div class="">
                    <div class="row  p-2">
                        @foreach ($products as $product)
                            <div class="p-item pt-2">
                                <div class="card">
                                    <div class="p-2">
                                        <div class="card-img-actions">
                                            <a href="{{route('user.viewProduct',[$product->id])}}"
                                               class="text-default mb-2"
                                               data-abc="true">
                                                <img data-src="{{asset($product->thumbnail)}}"
                                                     src="{{asset('img/default-site-img.png')}}" loading="lazy"
                                                     onerror="this.src=`{{asset('img/default-site-img.png')}}`"
                                                     class="card-img img-fluid lazyload"
                                                     id="product_thumbnail"
                                                      alt="product Image" >
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-left p-2 product-details">
                                        <div class="mb-2 product-title">
                                            <h4 class="font-weight-semibold mb-2" >
                                                <a href="{{route('user.viewProduct',[$product->id])}}"
                                                   class="text-default mb-2"
                                                   data-abc="true">{{$product->product_name}}</a>
                                            </h4>
                                        </div>
                                        <div class="short-description text-left">
                                            {!! $product->short_description !!}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-center">
                                            <h4 class="mb-0 font-weight-semibold text-info">{{$product->price}}৳</h4>

                                            <button type="button" class="buy-now btn bg-cart bg-primary m-2"
                                                    data-product="{{$product->id}}"><i class="fa fa-cart-plus mr-2"></i>
                                                Buy Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                </div>
                <div class=" mt-2" style="margin: 0 auto">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @if(isset($category))
                <div class="col-md-12 mt-5">
                    {!! $category->category_details !!}
                </div>
            @endif
        </div>
        @endsection
        @section('footer-script')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/elevatezoom.js"></script>
            <script>

                $(".buy-now").on('click', function () {
                    let productId = $(this).attr('data-product');
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
            </script>

@endsection