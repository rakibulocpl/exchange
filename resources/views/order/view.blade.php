@extends('layouts.admin')
@section('content')
    <style>

        .message-blue {
            position: relative;
            margin-left: 20px;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #A8DDFD;
            width: 200px;
            height: 50px;
            text-align: left;
            font: 400 .9em 'Open Sans', sans-serif;
            border: 1px solid #97C6E3;
            border-radius: 10px;
        }

        .message-orange {
            position: relative;
            margin-bottom: 10px;
            margin-left: calc(100% - 240px);
            padding: 10px;
            background-color: #f8e896;
            width: 200px;
            height: 50px;
            text-align: left;
            font: 400 .9em 'Open Sans', sans-serif;
            border: 1px solid #dfd087;
            border-radius: 10px;
        }

        .message-content {
            padding: 0;
            margin: 0;
        }

        .message-timestamp-right {
            position: absolute;
            font-size: .85em;
            font-weight: 300;
            bottom: 5px;
            right: 5px;
        }

        .message-timestamp-left {
            position: absolute;
            font-size: .85em;
            font-weight: 300;
            bottom: 5px;
            left: 5px;
        }

        .message-blue:after {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-top: 15px solid #A8DDFD;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            top: 0;
            left: -15px;
        }

        .message-blue:before {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-top: 17px solid #97C6E3;
            border-left: 16px solid transparent;
            border-right: 16px solid transparent;
            top: -1px;
            left: -17px;
        }

        .message-orange:after {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-bottom: 15px solid #f8e896;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            bottom: 0;
            right: -15px;
        }

        .message-orange:before {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-bottom: 17px solid #dfd087;
            border-left: 16px solid transparent;
            border-right: 16px solid transparent;
            bottom: -1px;
            right: -17px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-inverse-primary">{{ __('Update Details') }}</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <span class="v_label">Deal ID:</span> {{$dealData->tracking_no}}<br>
                                        <span class="v_label">Date:</span> {{$dealData->created_at}}<br>
                                        <span class="v_label">Name:</span> {{$dealData->customer_name }}<br>
                                        <span class="v_label">Phone:</span> {{$dealData->mobile_no}}<br>
                                        <span class="v_label">Address:</span> {{$dealData->address}}<br>
                                        <span class="v_label">City:</span> {{$dealData->city}}<br>
                                        <span class="v_label">Get Service From :</span> {{ucfirst($dealData->service_from)}}<br>
                                        <span class="v_label">Service Office :</span> {{ucfirst($dealData->selected_office)}}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <span class="v_label">Deal Status: </span>{{$dealData->status_name}}<br>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-6">
                                <div class="card card-outline-primary">
                                    <div class="card-header bg-primary text-white">
                                        Product List
                                    </div>

                                    <div class="card-body border rounded">
                                        <table class="table table-bordered">
                                            <thead class="text-center">
                                            <tr>
                                                <td>Code</td>
                                                <td>Name</td>
                                                <td>Action</td>
                                            </tr>

                                            </thead>
                                            <tbody>
                                            @foreach($products as $value)
                                                <tr>
                                                    <td>{{$value->product_code}}</td>
                                                    <td>{{$value->product_name}}</td>
                                                    <td><a style="cursor: pointer;padding:2px;" href="{{route('product.view',[$value->id])}}"><i class='fa fa-folder-open'></i></a></td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body border rounded">
                                        <div class="border rounded p-2 m-1">
                                            @if(!empty($dealData->estimated_cost))
                                                আনুমানিক খরচ : {{$dealData->estimated_cost}} টাকা

                                            @endif
                                            <br><br>
                                            <form method="post" action="{{route('deal.sendSms')}}"
                                                  id="estimatedPrice">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="deal_type" value="3"/>
                                                <div class="form-group">

                                                    <input type="hidden" value="{{$dealData->id}}" name="deal_id">
                                                    <input type="hidden" value="{{$dealData->phone}}"
                                                           name="customer_phone">
                                                    <div class="input-group mb-3">
                                                        <input type="text" min="0"
                                                               class="input-sm form-control border"
                                                               name="general_sms" required placeholder="Message ">
                                                        <div class="input-group-append">
                                                            <button id="sendSms" class="btn btn-success" type="submit">
                                                                send
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="message-container">
                                                @foreach($dealChat as $message)
                                                    <div class="message-orange">
                                                        <p class="message-content">{{$message->message}}</p>
                                                        <div class="message-timestamp-right">{{\Carbon\Carbon::parse($message->created_at)->format('d-M-Y')}}</div>
                                                    </div>
                                                @endforeach
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