@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center dashboard_row_main">
        <div class="row dashboard_row">
            <div class="col-lg-8">
                <div class="discriveProduct">
                    <h1 class=" n"> নষ্ট বা পুরাতন </h1>
                    <div class="home__title"> ল্যাপটপ ও ডেস্কটপ </div>
                    <span class="home__price"> দিয়ে নতুন ল্যাপটপ বা ডেস্কটপ নেওয়ার অফার চালু করেছে সিস্টেমআই টেকনোলজিস
                        !!</span>
                    <p class="home__description">
                        SystemEye Computer Exchange অফারে যেকোন নষ্ট, অচল বা সচল যেকোন পুরাতন ল্যাপটপ বা ডেস্কটপ ও
                        প্রয়োজনীয় টাকা দিয়ে যেকোন ব্র্যান্ডের নতুন কম্পিউটার নেওয়া যাবে।
                    </p>
                </div>
                <div class="featured__container grids">
                    @foreach($categories as $category)
                    <article class="featured__card">

                        <img src="{{$category->image_url}}" alt="" class="featured__img">
                        <a href="{{route('user.exchangeForm',[$category->id])}}" data-status="{{$category->status}}"
                            target="_blank"><button class=" featured__button">{{$category->name}}</button></a>
                    </article>

                    {{--                            <div class="featured__card">--}}
                    {{--                                <a class="exchange-category" href="{{route('user.exchangeForm',[$category->id])}}"
                    data-status="{{$category->status}}">--}}
                    {{--                                    <div class="card" style="width: 18rem;">--}}
                    {{--                                        <div class="card-body">--}}
                    {{--                                            <img class="category-img card-text" alt="Category " src="{{$category->image_url}}"
                    /><br />--}}
                    {{--                                            <span class="card-title btn btn-info"><b>{{$category->name}}</b></span>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </a>--}}
                    {{--                            </div>--}}
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4 siteImage">
                <img src="/site/img/a.jpeg" alt="" class="home__img">
            </div>
        </div>

    </div>
</div>
@endsection
@section('footer-script')
<script>
$(".exchange-category").on('click', function(e) {
    if ($(this).attr('data-status') == 0) {
        e.preventDefault();
        alert('Under construction !!');
    }

})
$(window).resize(function() {
    var width = $(window).width();
    if (width < 576) {
        $(".featured__container").addClass("row");
    } else {
        $(".featured__container").removeClass("row");
    }
});
</script>
@endsection