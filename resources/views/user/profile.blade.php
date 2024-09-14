@extends('layouts.admin')
@section('content')

    <div class="row user-profile">
        <div class="col-lg-4 side-left d-flex align-items-stretch">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                            <h4 class="card-title">Info</h4>
                            <img src="{{!empty(\Illuminate\Support\Facades\Auth::user()->photo_url)?url(\Illuminate\Support\Facades\Auth::user()->photo_url):url('images/blank.png')}}" alt="">
                            <p class="name"> {{\Illuminate\Support\Facades\Auth::user()->name}}</p>
                            <p class="designation">Designation</p>
                            <a class="d-block text-center text-dark" href="#">{{\Illuminate\Support\Facades\Auth::user()->email}}</a>
                            <a class="d-block text-center text-dark" href="#">+1 9438 934089</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-8 side-right stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Details</h4>
                        <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-expanded="true">Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar">Avatar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security">Security</a>
                            </li>
                        </ul>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <form action="{{route('user.profile-details-update')}}" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{\Illuminate\Support\Facades\Auth::user()->name}}" placeholder="Change user name">
                                    </div>
                                    <div class="form-group">
                                        <label for="designation">Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation" placeholder="Change designation">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Change mobile number">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" readonly value="{{\Illuminate\Support\Facades\Auth::user()->email}}" placeholder="Change email address">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" rows="6" class="form-control" placeholder="Change address"></textarea>
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                </form>
                            </div><!-- tab content ends -->
                            <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                                <div class="wrapper mb-5 mt-4">
                                    <span class="badge badge-warning text-white">Note : </span>
                                    <p class="d-inline ml-3 text-muted">Image size is limited to not greater than 1MB .</p>
                                </div>
                                <form action="{{route('user.profile-image-update')}}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                    <input type="file" class="dropify" name="profile_image" data-max-file-size="1mb" data-default-file="{{!empty(\Illuminate\Support\Facades\Auth::user()->photo_url)?url(\Illuminate\Support\Facades\Auth::user()->photo_url):url('images/blank.png')}}"/>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="change-password">Change password</label>
                                        <input type="password" class="form-control" id="change-password" placeholder="Enter you current password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="new-password" placeholder="Enter you new password">
                                    </div>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script src="{{asset('vendors/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('js/dropify.js')}}"></script>
@endsection
