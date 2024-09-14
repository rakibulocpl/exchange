@extends('layouts.admin')
@section('content')
    <link rel="stylesheet" href="{{asset('vendors/lightgallery/css/lightgallery.min.css')}}">
    <style>


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


        .image-tile {
            margin-left: 20px;
            max-height: 150px;
            width: 200px !important;
            flex: 0 0 45% !important;
            max-width: 45% !important;
        }

        .image-tile img {
            max-height: 120px;
            width: 200px !important;
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
                    <div class="card-header bg-inverse-primary">{{ __('Deal Details for '.$dealData->tracking_no) }}
                        <button class="btn btn-info pull-right" id="html2pdf"><i class="fa fa-print"></i>Print</button>
                    </div>
                    <div class="card-body" id="detailsView">
                        <h3 class="text-info text-center">{{$dealData->deal_type}}</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">

                                        <span class="v_label">Deal ID:</span> {{$dealData->tracking_no}}<br>
                                        <span class="v_label">Date:</span> {{$dealData->deal_date}}<br>
                                        <span class="v_label">Name:</span> {{$dealData->customerName }}<br>
                                        <span class="v_label">Phone:</span> {{$dealData->customerPhone}}
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <span class="v_label">Deal Status: </span>{{$dealData->status_name}}<br>
                                        <form method="post" id="dealNote" class="pt-4"
                                              action="{{route('deal.updateNote')}}">
                                            @csrf
                                            <div class="form-group">

                                                <input type="hidden" value="{{$dealData->id}}" name="deal_id">
                                                <div class="input-group mb-3">
                                                    <textarea name="deal_note" rows="2"
                                                              class="form-control required">{{$dealData->deal_note}}</textarea>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-success pull-right" value="Update">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 5px">
                            <div class="col-md-6">
                                <div class="card">

                                    <div class="card-body border rounded">
                                        <span class="v_label">Product: </span> {{$dealData->product}}<br>
                                        <span class="v_label">Brand:</span> {{$dealData->brandName}}<br>
                                        <span class="v_label">Model:</span> {{$dealData->model}}<br><br>

                                        <strong class="text-info">Specification and Condition:</strong><br><br>
                                        <span class="v_label">Laptop Power:</span> {{$details->laptoppower}}<br>
                                        <span class="v_label">Processor: </span> {{($details->processor?explode('@',$details->processor)[1]:'').' / '.$details->processorstatus}}
                                        <br>
                                        <span class="v_label">RAM:</span> {{($details->ram?explode('@',$details->ram)[1]:'').' / '.$details->ramstatus}}
                                        <br>
                                        <span class="v_label">Storage:</span> {{($details->storage?explode('@',$details->storage)[1]:'').' / '.$details->storagestatus}}
                                        <br>
                                        <span class="v_label">Display:</span> {{($details->display?explode('@',$details->display)[1]:'').' / '.$details->displaystatus}}


                                        @if(!empty($details->monitor_brand))
                                            <span class="v_label">Monitor Brand: </span> {{($details->monitor_brand?explode('@',$details->monitor_brand)[1]:'')}}
                                            <br>
                                        @endif

                                        @if(!empty($details->monitor_size))
                                            <span class="v_label">Monitor Size: </span> {{($details->monitor_size?explode('@',$details->monitor_size)[1]:'')}}
                                            <br>
                                        @endif
                                        <br>
                                        @if(!empty($details->battery))
                                        <span class="v_label">Battery Backup:</span> {{($details->battery?explode('@',$details->battery)[1]:'')}}
                                        <br>
                                        @endif
                                        <span class="v_label">Graphics Card: </span> {{($details->graphics?explode('@',$details->graphics)[1]:'').' / '.$details->graphicsstatus}}

                                        <br>
                                        @if(!empty($details->physicalstatus))
                                            <span class="v_label">Physical Condition: </span> {{$details->physicalstatus}}
                                        @endif
                                        <br>

                                        <span class="v_label">More Condition:</span> <br>
                                        @if(!empty($details->more_condition))
                                            <ul>

                                            </ul>
                                            @foreach($details->more_condition as $value)
                                                <li>{{$value}}</li>
                                            @endforeach
                                        @endif


                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="card">

                                    <div class="card-body border rounded">
                                        <div id="lightgallery" class="row lightGallery">
                                            <a href="/{{$dealData->back_image}}" class="image-tile img-thumbnail"><img
                                                        src="/{{$dealData->back_image}}" alt="image small"></a>
                                            <a href="/{{$dealData->font_image}}" class="image-tile img-thumbnail"><img
                                                        src="/{{$dealData->font_image}}" alt="image small"></a>
                                        </div>
                                        <div class="border rounded p-2 m-1">
                                            @if(!empty($dealData->estimated_price))
                                                আনুমানিক মূল্য : {{$dealData->estimated_price}} টাকা

                                            @endif
                                            @if($dealData->status == 1)
                                                <form method="post" action="{{route('deal.sentEstimatedPrice')}}"
                                                      id="estimatedPrice">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                    <div class="form-group">
                                                        আপনার পচণ্যর সচেবাচ্চ মূল্য হবে:
                                                        @php
                                                            $priceRange = '';
                                                            if (!empty($dealData->total_price_calculated)) {
                                                                $lowerBound = $dealData->total_price_calculated - ($dealData->total_price_calculated * 15) / 100;
                                                                $upperBound = $dealData->total_price_calculated + ($dealData->total_price_calculated * 15) / 100;
                                                                $priceRange = $lowerBound . '-' . $upperBound;
                                                            }

                                                        @endphp
                                                        <input type="text" min="0" class="input-sm"
                                                               name="estimated_price"
                                                               value="{{ $priceRange }}"
                                                                required>
                                                        <input type="hidden" value="{{$dealData->id}}"
                                                               name="deal_id">
                                                        <input type="hidden" value="{{$dealData->customerPhone}}"
                                                               name="customer_phone">
                                                        <button class="btn btn-success" id="sendPrice">
                                                            Send Price
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif

                                            <br><br>
                                            <form method="post" action="{{route('deal.sendSms')}}"
                                                  id="chatForm">
                                                <input type="hidden" name="deal_type" value="1"/>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                <div class="form-group">

                                                    <input type="hidden" value="{{$dealData->id}}" name="deal_id">
                                                    <input type="hidden" value="{{$dealData->customerPhone}}"
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
                        @if(!empty($dealData->price_list_calculated))
                            <div id="priceDetails" class=" p-2">
                                <h2>Price Details</h2>
                                <table class="table table-striped">
                                    <thead class="bold">
                                    <tr>
                                        <th>Component Name</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $totalPrice  = 0;
                                    @endphp

                                    @foreach(json_decode($dealData->price_list_calculated) as $item)
                                        @php
                                            $price =  empty($item->price)?0:$item->price
                                        @endphp
                                        <tr>
                                            <th>{{ucfirst($item->component)}}</th>
                                            <th>{{$item->details}}</th>
                                            <th>{{$item->status}}</th>
                                            <th>{{$price}}</th>
                                        </tr>
                                        @php
                                            $totalPrice+= $price
                                        @endphp
                                    @endforeach
                                    </tbody>
                                    <tfoot class="bg-success text-white bol">
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th >{{$totalPrice}}</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif

                        <div id="dealByThisUser" class=" p-2">
                            <h2>Deal List by this user</h2>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Deal Type</th>
                                    <th>Tracking No</th>
                                </tr>
                                @foreach($dealByThisUser as $deal)
                                    <tr>
                                        <th>{{$deal->deal_type}}</th>
                                        <th><a target="_blank"
                                               href="/admin/deal/view/{{$deal->id}}">{{$deal->tracking_no}}</a></th>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script src="{{asset('vendors/lightgallery/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('js/light-gallery.js')}}"></script>
    <script src="https://uat-moha.oss.net.bd/assets/scripts/moment.min.js"></script>
    <script src="https://uat-moha.oss.net.bd/vendor/html2pdf/html2pdf.bundle.js"></script>
    <script>
        var is_generate_pdf = false;
        document.getElementById("html2pdf").addEventListener("click", function (e) {
            if (!is_generate_pdf) {
                $('#html2pdf').children().removeClass('fa-print').addClass('fa-spinner fa-pulse');
                generatePDF();
            }
        });

        function generatePDF() {
            $('#html2pdf').hide();
            $('#chatForm').hide();
            $('#dealByThisUser').hide();
            $('#estimatedPrice').hide();
            var element = $('#detailsView').html();
            $('#html2pdf').show();
            $('#dealByThisUser').show();
            $('#printableArea').show();
            var downloadTime = 'Download time: ' + moment(new Date()).format('DD-MMM-YYYY h:mm a');
            var opt = {
                margin: [0.40, 0.40, 0.80, 0.40], //top, left, bottom, right
                // filename:     'myfile.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                },
                enableLinks: true,
                pagebreak: {before: '#impInfo'}
            };
            var html = element;

            html2pdf().from(html).set(opt).toPdf().get('pdf').then(function (pdf) {
                var pageCount = pdf.internal.getNumberOfPages();

                pdf.setPage(1);
                pageWidth = pdf.internal.pageSize.getWidth();
                pageHeight = pdf.internal.pageSize.getHeight();

                pdf.setFontSize(14);
                // pdf.text("গণপ্রজাতন্ত্রী বাংলাদেশ সরকার", 1.80, 1.20);

                pdf.setFontType("italic");
                pdf.setFontSize(8);
                pdf.setTextColor(32, 32, 32);

                for (let j = 1; j < pageCount + 1; j++) {
                    pdf.setPage(j);
                    // pdf.text(`${j} / ${pageCount}`, pageWidth - 1, pageHeight - 0.50);
                    // pdf.text(downloadTime, 0.60, pageHeight - 0.50);
                }

                //generated url
                var url = pdf.output('bloburl');
                $('#html2pdf').children().removeClass('fa-spinner fa-pulse').addClass('fa-print');
                $('#html2pdf').attr({
                    href: url,
                    target: "_blank"
                });
                is_generate_pdf = true;
                window.open(url, '_blank');
            });
        }
    </script>
@endsection