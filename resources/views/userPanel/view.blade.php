@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('inc/message')
                <div class="card">
                    <div class="card-header bg-inverse-primary">
                        {{ __('Deal Details for '.$dealData->tracking_no) }}
                        <a class="btn btn-info pull-right" href="{{url('/')}}">
                            <span class="spinner-grow spinner-grow-sm text-danger" role="status" aria-hidden="true"></span>
                            <span class="visually-hidden">Submit Another Deal</span></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">

                                        <span class="v_label">Deal ID:</span>  {{$dealData->tracking_no}}<br>
                                        <span class="v_label">Date:</span>  {{$dealData->deal_date}}<br>
                                        <span class="v_label">Name:</span>  {{$dealData->customerName }}<br>
                                        <span class="v_label">Phone:</span>  {{$dealData->customerPhone}}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <span class="v_label">Deal Status: </span>{{$dealData->status_name}}<br>
                                        <span class="v_label">Deal Type: </span>{{$dealData->deal_type}}<br>
                                        @if(!empty($dealData->estimated_price))
                                            <br>
                                            <strong class="text-primary">আনুমানিক মূল্য : {{$dealData->estimated_price}} টাকা</strong>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <span class="v_label">Product: </span> {{$dealData->product}}<br>
                                        <span class="v_label">Brand:</span>  {{$dealData->brandName}}<br>
                                        <span class="v_label">Model:</span>  {{$dealData->model}}<br><br>

                                        <strong class="text-info">Specification and Condition:</strong><br><br>
                                        <span class="v_label">Power:</span> {{$details->laptoppower}}<br>
                                        <span class="v_label">Processor: </span> {{($details->processor?explode('@',$details->processor)[1]:'').' / '.$details->processorstatus}}<br>
                                        <span class="v_label">RAM:</span>  {{($details->ram?explode('@',$details->ram)[1]:'').' / '.$details->ramstatus}}<br>
                                        <span class="v_label">Storage:</span> {{($details->storage?explode('@',$details->storage)[1]:'').' / '.$details->storagestatus}}<br>
                                        <span class="v_label">Display:</span>  {{($details->display?explode('@',$details->display)[1]:'').' / '.$details->displaystatus}}<br>
                                        @if(!empty($details->monitor_brand))
                                            <span class="v_label">Monitor Brand: </span> {{($details->monitor_brand?explode('@',$details->monitor_brand)[1]:'')}}
                                            <br>
                                        @endif

                                        @if(!empty($details->monitor_size))
                                            <span class="v_label">Monitor Size: </span> {{($details->monitor_size?explode('@',$details->monitor_size)[1]:'')}}
                                            <br>
                                        @endif
                                        @if(!empty($details->battery))
                                            <span class="v_label">Battery Backup:</span> {{($details->battery?explode('@',$details->battery)[1]:'')}}
                                            <br>
                                        @endif
                                        <span class="v_label">Graphics Card: </span>  {{($details->graphics?explode('@',$details->graphics)[1]:'').' / '.$details->graphicsstatus}}<br>
                                        @if(!empty($details->physicalstatus))
                                            <span class="v_label">Physical Condition: </span>  {{ucfirst($details->physicalstatus)}}<br>
                                        @endif

                                        <span class="v_label">More Condition:</span> <br>
                                        @if(!empty($details->more_condition))
                                            <ul>
                                                @foreach($details->more_condition as $value)
                                                    <li>{{$value}}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <img src="/{{$dealData->font_image}}" class="img-thumbnail" />
                                            </div>
                                            <div class="col-md-6">
                                                <img src="/{{$dealData->back_image}}" class="img-thumbnail" />
                                            </div>
                                        </div>
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