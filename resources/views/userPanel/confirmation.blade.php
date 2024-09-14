@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @include('inc/message')
                <div class="card bg-exchange " style="margin: 0 auto; font-weight: bold">
                    <div class="card-body text-center">
                        <h3 style="font-size: 2rem">Thank you</h3>
                        <p style="font-size: 1.3rem">for providing the information .You will receive the pricing details via SMS Shortly.</p>
                    <br>
                        <div>
                            <a href="/" class="btn btn-primary pull-left" >Close</a><a href="/" class="btn btn-primary pull-right">Submit Another Deal</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection