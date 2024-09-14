@extends('layouts.admin')
@section('content')
<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Employee List</h6>
{{--                <div class="d-flex table-responsive">--}}

{{--                    <div class="btn-group pull-right">--}}
{{--                        <a href="{{route('employee.create')}}" class="btn btn-sm btn-info"><i class="mdi mdi-plus-circle-outline"></i> Add</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="table-responsive">
                    <table class="table mt-3 border-top" id="employeetable">
                        <thead>
                        <tr>
                            <th>#id</th>
                            <th>Employee</th>
                            <th>Position</th>
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
                    url: '{{route("employee.getlist")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'emp_id', name: 'emp_id'},
                    {data: 'name', name: 'name'},
                    {data: 'position', name: 'position'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });
        });

    </script>
@endsection
