@extends('layouts.user')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

@section('content')
    <style>
        .short-description li {
            font-size: 13px;
            color: #666;
            position: relative;
            line-height: 16px;
            padding-bottom: 10px;
        }
        .category-box {
            padding: 5px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 16px;
            box-shadow: 2px 2px 2px 2px rgb(140, 148, 151,1);
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
            grid-template-columns: repeat(8, 1fr);
            gap: 16px;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .category-box img {
            height: 80px;
            width: 80px;
            background-size: cover;
            border-radius: 50%;
            background: white;
        }
        @media screen and (max-width: 688px) {
            .category-list-box{
                display: grid;
                grid-template-columns: repeat(4, 1fr);
            }
            /** end -:- (Screen Less Than 688) **/
        }
        @media screen and (max-width: 460px) {
            /*.thematic-card {*/
            /*    min-width: 120px;*/
            /*}*/
            .category-list-box{
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
            }
            .category-list-box a{
              font-size: 12px;
            }
            .category-box img {
                height: 50px;
                width: 50px;

            }
            /** end -:- (Screen Less Than 414) **/
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
    <div class="container">
        <div class="row justify-content-center dashboard_row_main">
            <div class="col-md-8 home-page-slider">
                <div class="swiper mySwiper">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper" style="height: auto">
                        <!-- Slides -->
                        @foreach($sliders as $slider)
                            <div class="swiper-slide">
                                <img class="img-responsive img-fluid" style="max-height: 380px" src="{{$slider->path}}" onerror="this.src=`{{asset('img/default-site-img.png')}}`">
                            </div>
                        @endforeach
                        ...
                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>

                </div>

            </div>
            <div class="col-md-4  p-2 bg-exchange" style="border-radius: 5px;border: 1px solid #8d9690">
                <h2 class="justify-content-center text-center  pl-2 pr-2 pb-2 m text-black"
                    style="border-radius: 5px; color: #454241; margin: 13px 13px 0px 13px;">
                    সেবা পেতে আপনার ডিভাইসের তথ্য দিন

                </h2>
                <div>

                    <div class="tab justify-content-around">
                        <button class="tablinks active" onclick="openCity(event, 'Sell')">Sell</button>
                        <button class="tablinks" onclick="openCity(event, 'Exchange')">Exchange</button>
                        <button class="tablinks" onclick="openCity(event, 'upgrade')">Upgrade</button>
                    </div>

                    <div id="Sell" class="tabcontent" style="display: block !important;">
                        <form id="sellfrom" action=""
                              method="post" encType="multipart/form-data">
                            <div class="form-group">
                                {!! Form::select('product', [''=>'Select Product','2'=>'Laptop','3'=>'Desktop'],'',['class' => 'form-control input-md required','id'=>'sell-product',]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::select('brand',$brands,'',['class' => 'form-control input-md required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('model','',['class' => 'form-control input-md ','id'=>'model','placeholder'=>'Write Model (optional)']) !!}
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary " type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                    <div id="Exchange" class="tabcontent">
                        <form id="exchangeForm" action=""
                              method="post" encType="multipart/form-data">
                            <div class="form-group">
                                {!! Form::select('product', [''=>'Select Product','2'=>'Laptop','3'=>'Desktop'],'',['class' => 'form-control input-md required','id'=>'exchange-product',]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::select('brand',$brands,'',['class' => 'form-control input-md required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('model','',['class' => 'form-control input-md ','id'=>'model','placeholder'=>'Write Model (optional)']) !!}
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary " type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                    <div id="upgrade" class="tabcontent">
                        <form id="upgradeForm" action=""
                              method="post" encType="multipart/form-data">
                            <div class="form-group">
                                {!! Form::select('product', [''=>'Select Product','2'=>'Laptop','3'=>'Desktop'],'',['class' => 'form-control input-md required','id'=>'upgrade-product',]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::select('brand',$brands,'',['class' => 'form-control input-md required']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('model','',['class' => 'form-control input-md ','id'=>'model','placeholder'=>'Write Model (optional)']) !!}
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary " type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="category-list-box">
                <?php
                $allCategory = getCategory();
                ?>
                @foreach ($allCategory as $category)
                    @if ($category->children->count() > 0)
                        @foreach ($category->children as $childCategory)

                            <div class="category-box">
                                <a href="{{route('user.shopByCategory',[$childCategory->slug])}}" >
                                    <img src="/uploads/2023/09/laptop_650d7ee6a047c0.55649286.png" alt="Category Image">
                                    <span>{{$childCategory->name}}</span>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="category-box">
                            <a href="{{route('user.shopByCategory',[$category->slug])}}" >
                                <img src="{{!empty($category->image)?'/'.$category->image:'/img/blog/1.jpg'}}" alt="Category Image">
                                <span>{{$category->name}}</span>
                            </a>
                        </div>
                    @endif

                @endforeach
            </div>

        </div>
        @include('userPanel.home-page-product-gallery')

        <div class="m-5" style="height: 200px">
            <h2 class="text-center bg-exchange p-2">
                Press Coverage
            </h2>
            <br/>
            <div class="swiper newSMedia text-center">
                <div class="swiper-wrapper">
                    @foreach($newsItem as $news)
                        <div class="swiper-slide">
                            <a href="{{route('pressAndMedia')}}">
                                <img class="img-responsive img-fluid lazyload"  src="{{asset('img/default-site-img.png')}}"  loading="lazy" style="max-height: 80px" data-src="{{$news->logo}}" onerror="this.src=`{{asset('img/default-site-img.png')}}`">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
@endsection
@section('footer-script')
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>

    <!-- Initialize Swiper -->
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 50,
            loop: true,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
        var newSMedia = new Swiper(".newSMedia", {
            watchSlidesProgress: true,
            slidesPerView: 6,
            loop: true,
            autoplay: {
                delay: 5000,
            },

            // Responsive breakpoints
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                // when window width is >= 480px
                480: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                // when window width is >= 640px
                640: {
                    slidesPerView: 5,
                    spaceBetween: 40
                }
            }
        });
    </script>

    <script>


        $('#sellfrom').validate({
            errorPlacement: function () {
                return false;
            },
            submitHandler: function (form) {
                let formData = $("#sellfrom").serialize(['brand', 'model']);
                let product = $("#sell-product").val();
                window.location.href = '/sell/' + product + '?' + formData;
            }
        });

        $('#exchangeForm').validate({
            submitHandler: function (form) {
                let formData = $("#exchangeForm").serialize(['brand', 'model']);
                let product = $("#exchange-product").val();
                window.location.href = '/exchange/' + product + '?' + formData;
            }
        });

        $('#upgradeForm').validate({
            submitHandler: function (form) {
                let formData = $("#upgradeForm").serialize(['brand', 'model']);
                let product = $("#upgrade-product").val();
                window.location.href = '/upgrade/' + product + '?' + formData;
            }
        });

        $(".exchange-category").on('click', function (e) {
            if ($(this).attr('data-status') == 0) {
                e.preventDefault();
                alert('Under construction !!');
            }

        })
        $(window).resize(function () {
            var width = $(window).width();
            if (width < 576) {
                $(".featured__container").addClass("row");
            } else {
                $(".featured__container").removeClass("row");
            }
        });
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