@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Products <a class="btn btn-light pull-right" href="{{route('products.add')}}"><i class="fa fa-plus"></i>New</a></h4>

                    {{-- <div class="row grid-margin">
                         <div class="col-12">
                             <div class="alert alert-warning" role="alert">
                                 <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
                             </div>
                         </div>
                     </div>--}}
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="products-list" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th>sl #</th>
                                        <th>Product name</th>
                                        <th>Actions</th>
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
            $('#products-list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                ajax: {
                    url: '{{route("products.active.index")}}',
                    method: 'GET'
                },
                columns: [
                    {data: 'slno', name: 'slno'},
                    {data: 'name', name: 'nid'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "aaSorting": []
            });
        });

    </script>
@endsection
