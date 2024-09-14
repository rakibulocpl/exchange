@extends('layouts.admin')
@section('content')
    <div class="row grid-margin">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Recent leave applied</h6>

                    <div class="d-flex table-responsive">

                        <div class="btn-group pull-right">
                            <a href="{{route('leave.addnew')}}" class="btn btn-sm btn-info"><i class="mdi mdi-plus-circle-outline"></i> Add New</a>
                        </div>
                    </div>
                    <br>

                    <div class="table-responsive">
                        <table class="table mt-3 border-top" id="employeetable">
                            <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>No. of Days</th>
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
@endsection
@section('footer-script')
    @include('inc/datatable-script')
    <script>
        $(function () {
            $('#employeetable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                ajax: {
                    url: '{{route("leave.getleavelist")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'emp_id', name: 'emp_id'},
                    {data: 'name', name: 'name'},
                    {data: 'date_range', name: 'date_range'},
                    {data: 'no_of_days', name: 'no_of_days'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });
        });

    </script>
@endsection
