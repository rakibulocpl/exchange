@extends('layouts.admin')
<style>
    tr{
        border:1px solid black !important;
    }
    .table.dataTable{
        border: 1px solid #ced4da !important;
    }
</style
@section('content')
    <div class="container">
        <div class="container">
            <div class="card   my-3 p-3">
                <div id="form-header" class="text-center p-3">
                    <h2 class="font-weight-bold">Proposal List</h2>
                </div>
                <div class="col-md-12" >
                    <div class="card">
                        <div class="card-body">
                            @if(Auth::user()->user_type == 'company')
                                <div class="btn-group pull-right">
                                    <a href="{{route('user.newProposal')}}" class="btn btn-sm btn-info pull-right"><i class="mdi mdi-plus-circle-outline"></i> Add New</a>
                                </div>
                            @endif

                            <br>
                            <br>

                            <div class="table-responsive">
                                <table class="table mt-3 border-top" id="proposalTable">
                                    <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Ownership Type</th>
                                        <th>Owner Name</th>
                                        <th>Owner Contact</th>
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
            $('#proposalTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                ajax: {
                    url: '{{route("user.getProposalList")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'company_name', name: 'company_name'},
                    {data: 'ownership_type_name', name: 'ownership_type_name'},
                    {data: 'owner_name', name: 'owner_name'},
                    {data: 'owner_contact_no', name: 'owner_contact_no'},
                    {data: 'app_status', name: 'app_status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });
        });

    </script>
@endsection