@extends('layouts.user')
@section('content')

    <div class="container">

        <div class="row user-profile">
            <div class="col-md-3 page-sider">
                <aside>
                    <div class="inner-box">
                        <div class="user-panel-sider">
                            <div class="collapse-box">
                                <h5 class="collapse-title no-border">
                                    My Account&nbsp;
                                    <a href="#MyClassified" data-bs-toggle="collapse" class="float-end"><i class="fa fa-angle-down"></i></a>
                                </h5>
                                <div class="panel-collapse collapse show" id="MyClassified">
                                    <ul class="acc-list">
                                        <li>
                                            <a class="active" href="/my-account">
                                                <i class="fa fa-home"></i> Personal Home
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="collapse-box">
                                <h5 class="collapse-title">
                                    My Deal
                                    <a href="#MyAds" data-bs-toggle="collapse" class="float-end"><i class="fa fa-angle-down"></i></a>
                                </h5>
                                <div class="panel-collapse collapse show" id="MyAds">
                                    <ul class="acc-list">
                                        <li>
                                            <a href="/my-deal"><i class="icon-docs"></i> Deal List&nbsp;</a>

                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-lg-8 side-right stretch-card">
                <div class="card card-default">
                    <div class="card-header">
                        <h4 class="card-title">
                            My Deal List
                        </h4>
                    </div>
                    <div class="panel-collapse collapse show" id="userPanel">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                      <th>Deal Id</th>
                                      <th>Product</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @foreach($dealList as $deal)
                                    <tr>
                                        <td>{{$deal->tracking_no}}</td>
                                        <td>{{$deal->product}}</td>
                                        <td>{{$deal->status_name}}</td>
                                        <td><a href="{{route('user.dealView',[$deal->tracking_no])}}"><i class="fa fa-folder-open"></i></a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer-script')
    <script>
        $(document).ready(function() {

            $("#city").on("change",function (){
                let cityid = $(this).val();
                $.ajax({
                    url: 'info/get-thana/'+cityid,
                    type: "GET",
                    success: function(response) {
                        var option = '<option value="">Select One</option>';
                        $.each(response, function (key, row) {
                            option += '<option selected="true" value="' + row.id + '">' + row.display + '</option>';
                        });
                        $("#thana").html(option)
                    }
                });
            });
            $("#city").trigger("change");
        });

        $("#userProfile").validate();
    </script>
@endsection
