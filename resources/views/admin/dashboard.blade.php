@extends('layouts.admin')
@section('content')

{{--    <fieldset>--}}
{{--        <legend>Daily Report</legend>--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-6 col-sm-6 col-lg-3 col-xs-6 grid-margin stretch-card">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center justify-content-md-center">--}}
{{--                            <i class="icon-user-following icon-lg text-success"></i>--}}
{{--                            <div class="ml-3">--}}
{{--                                <strong class="mb-0 text-info">SALES</strong>--}}
{{--                                <h6>{{$data['sales']}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-lg-3 col-sm-6 col-xs-6 grid-margin stretch-card">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center justify-content-md-center">--}}
{{--                            <i class="icon-user-following icon-lg text-success"></i>--}}
{{--                            <div class="ml-3">--}}
{{--                                <strong class="mb-0 text-info">COLLECTION</strong>--}}
{{--                                <h6>{{$data['collection']}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-lg-3 col-sm-6 col-xs-6 grid-margin stretch-card">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center justify-content-md-center">--}}
{{--                            <i class="icon-user-following icon-lg text-success"></i>--}}
{{--                            <div class="ml-3">--}}
{{--                                <strong class="mb-0 text-info">Purchase</strong>--}}
{{--                                <h6>{{$data['purchase']}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-lg-3 col-sm-6 col-xs-6 grid-margin stretch-card">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center justify-content-md-center">--}}
{{--                            <i class="icon-user-following icon-lg text-success"></i>--}}
{{--                            <div class="ml-3">--}}
{{--                                <strong class="mb-0 text-info">Profit/loss</strong>--}}
{{--                                <h6>{{$data['profit']}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </fieldset>--}}
{{--    <fieldset>--}}
{{--        <legend>Product </legend>--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-6 col-sm-6 col-lg-3 col-xs-6 grid-margin stretch-card">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center justify-content-md-center">--}}
{{--                            <i class="icon-user-following icon-lg text-success"></i>--}}
{{--                            <div class="ml-3">--}}
{{--                                <strong class="mb-0 text-info">Total Quantity </strong>--}}
{{--                                <h6>{{$data['stock']->total_quantity}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-6 col-lg-3 col-sm-6 col-xs-6 grid-margin stretch-card">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="d-flex align-items-center justify-content-md-center">--}}
{{--                            <i class="icon-credit-card icon-lg text-success"></i>--}}
{{--                            <div class="ml-3">--}}
{{--                                <strong class="mb-0 text-info">Total Cost</strong>--}}
{{--                                <h6>{{$data['stock']->total_cost}}</h6>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </fieldset>--}}

    <div class="row">
        <div class="col-lg-4 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-md-4 col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-md-4 col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">


                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 col-md-4 col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('footer-script')

@endsection
