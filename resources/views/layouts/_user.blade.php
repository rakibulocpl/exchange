<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="@yield('meta_title', 'ExchangeKori')">
    <meta name="description" content="@yield('meta_description','exchange')">
    <meta name="keywords" content="@yield('meta_keyword','exchange')">
    <meta property="og:image"             content="{{asset('/img/default-site-img.png')}}" />
    <meta property="og:image:secure_url"  content="{{asset('/img/default-site-img.png')}}" />

    <title>ExchangeKori</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js" async defer></script>
    <link rel="icon" type="/site/image/x-icon" href="/site/img/favicon.ico">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendors/font-awesome/css/font-awesome.min.css')}}"/>

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
          integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{ asset('css/dashboardResponsive.css') }}">
    <style>
        .profileImage {
            width: 35px;
            height: 34px;
            border-radius: 50%;
            background: #512DA8;
            font-size: 30px;
            color: #fff;
            text-align: center;
            line-height: 35px;
            display: inline-block;
        }
    </style>
</head>

<body>
<div id="app">

    <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/site/img/logo.png" alt="" class="logo__img">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto" style="font-size: 18px;margin: 0 auto;">
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('user.sellForm')}}">{{ __('Sell') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('user.exchangeForm')}}">{{ __('Exchange') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{route('user.shop')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('Buy') }}</a>
                                    <?php
                                    $categories = getCategory();
                                    ?>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @foreach ($categories as $category)
                                @if ($category->children->count() > 0)
                                <li class="dropdown-item dropdown">
                                    <a class="nav-item dropdown-toggle" href="#" id="navbarDropdownMenuLink{{$category->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ $category->name }} <i class="fa fa-angle-right"></i></a>
                                        @include('userPanel.child-categories', ['categories' => $category->children,'cat_id'=>$category->id])
                                </li>
                                @else
                                <li>
                                    <a class="dropdown-item" href="{{route('user.shopByCategory',[$category->slug])}}"> {{ $category->name }} </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('user.upgradeForm')}}">{{ __('Upgrade') }}</a>
                    </li>
                </ul>
                <form class="form-inline" style="right: 0;margin: auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search device for buy">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" style="background: none;color: black" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item text-center">
                            <a class="nav-link bnt  btn-xs"
                               style="color: #fff;font-size:16px;border-radius: 30px !important;min-width: 100px;max-width: 100px;;font-weight: bold; padding: 4px 12px !important;color: rgba(0, 0, 0, 0.5); border: 1px solid #3490dc "
                               href="{{ route('userLogin') }}"> {{ __('Login') }}
                            </a>
                        </li>

                    @else
                        <li class="nav-item dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                <?php
                                $first_character = substr(\Illuminate\Support\Facades\Auth::user()->name, 0, 1);
                                ?>
                                <span class="profileImage">{{strtoupper($first_character)}}</span>
                                <div class="dropdown-menu user-details" aria-labelledby="dropdownMenuButton">
                                    <div class="d-flex no-block align-items-center p-3 bg-primary text-white mb-2">
                                        <div class="">
                                            <span class="profileImage">{{strtoupper($first_character)}}</span>
                                        </div>
                                        <div class="m-2">
                                            <h4 class="mb-0 text-white">{{\Illuminate\Support\Facades\Auth::user()->name}}
                                            </h4>
                                            <p class="mb-0">{{\Illuminate\Support\Facades\Auth::user()->phone}}</p>
                                        </div>
                                    </div>
                                    <a class="dropdown-item" href="/my-account">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="feather feather-user feather-sm text-info me-1 ms-1">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2">

                                            </path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        My account</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="feather feather-log-out feather-sm text-danger me-1 ms-1">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        Sign Out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
    @include('inc/user-footer')
</div>

<script src="{{asset('vendors/js/vendor.bundle.base.js')}}"></script>

@yield('footer-script')

<script>
    $(document).ready(function () {
        $(".dropdown-toggle").dropdown();
    });
</script>
</body>

</html>