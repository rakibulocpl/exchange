@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-inverse-primary">

                    <h4 class="card-title">Order List </h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="list" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th>sl #</th>
                                        <th>Tracking No</th>
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Submit Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="commonmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="commonmodalTitle">Edit Branch</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="errorMsg alert alert-danger alert-dismissible" style="display: none">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                    <div class="successMsg alert alert-success alert-dismissible" style="display: none">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>
                    <div class="card" >
                        <div class="card-body" id="modelbody">


                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
@endsection
@section('footer-script')
    @include('inc/datatable-script')
    <script>
        $(function () {
            commonlist =$('#list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                ajax: {
                    url: '{{route("order.getList")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'tracking_no', name: 'tracking_no'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'status_name', name: 'status_name'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'}
                ],
                "aaSorting": []
            });
        });


    </script>
@endsection
