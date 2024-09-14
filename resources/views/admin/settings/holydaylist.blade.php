@extends('layouts.admin')
@section('content')
    <div class="row grid-margin">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Holy Day List Of {{date('Y')}}</h6>

                                    <div class="d-flex table-responsive">

                                        <div class="btn-group pull-right">
                                            <a href="{{route('settings.addallfirday')}}" class="btn btn-sm btn-info"><i class="mdi mdi-plus-circle-outline"></i> Add all Friday</a>
                                            <a href="{{route('settings.addnewholyday')}}" class="btn btn-sm btn-info"><i class="mdi mdi-plus-circle-outline"></i> Add New</a>
                                        </div>
                                    </div>
                    <br>

                    <div class="table-responsive">
                        <table class="table mt-3 border-top" id="employeetable">
                            <thead>
                            <tr>
                                <th>#sl</th>
                                <th>Date</th>
                                <th>Title</th>
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
                    url: '{{route("settings.getholydaylist")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'date', name: 'date'},
                    {data: 'title', name: 'title'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });
        });

    </script>
@endsection
