@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-inverse-primary">
                    <h4 class="card-title">Product List <a class="btn btn-warning pull-right" href="{{route('product.add')}}"><i class="icon-plus"></i> Add New</a> </h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="list" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th>sl #</th>
                                        <th>Name</th>
                                        <th>Status</th>
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
                    url: '{{route("product.getList")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ],
                "aaSorting": []
            });
        });


    </script>
@endsection
