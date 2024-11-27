@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                @include('inc/message')

                <!-- Thank You Card with Exchange Message -->
                <div class="card border-0 shadow-lg mt-5" style="border-radius: 20px; background-color: #f9fbfd;">
                    <div class="card-body text-center p-5">
                        <!-- Icon and Thank You Message -->
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="text-dark" style="font-size: 2.2rem; font-weight: 700;">Thank You!</h3>
                        <p style="font-size: 1.2rem; color: #555;">
                            Your {{$dealType??'exchange'}} request has been received. We’ll send you the pricing details via SMS shortly.
                        </p>

                        <!-- New/Used Device Selection Section as Cards -->
                        @if($dealType == 'exchange')
                            <div class="mt-5">
                                <p style="font-weight: bold; font-size: 1.3rem; color: #333;">Select the type of device you’d like to exchange:</p>
                                <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                                    <a href="/category/brand-new-laptop?dealId={{$dealId}}" class="text-decoration-none">
                                        <div class="card p-3 text-center" style="width: 160px; height: 100px; border-radius: 10px; border: 1px solid #ddd; cursor: pointer; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;">
                                            <i class="fas fa-mobile-alt text-success" style="font-size: 1.5rem;"></i>
                                            <h5 class="mt-2 text-dark">New Device</h5>
                                        </div>
                                    </a>
                                    <a href="/category/laptop-pre-owned?dealId={{$dealId}}" class="text-decoration-none ml-1">
                                        <div class="card p-3 text-center" style="width: 160px; height: 100px; border-radius: 10px; border: 1px solid #ddd; cursor: pointer; transition: all 0.3s; display: flex; flex-direction: column; justify-content: space-between;">
                                            <i class="fas fa-mobile-alt text-secondary" style="font-size: 1.5rem;"></i>
                                            <h5 class="mt-2 text-dark">Pre-owned Device</h5>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        @endif


                        <!-- Action Buttons Section -->
                        <div class="mt-4 d-flex justify-content-between">
                            <a href="/" class="btn btn-outline-primary" style="width: 48%;">Close</a>
                            <a href="/" class="btn btn-outline-primary" style="width: 48%;">Submit Another Deal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
