@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-inverse-primary">
                    <h4 class="card-title">Page List <a class="btn btn-warning pull-right" href="{{route('page.add')}}"><i class="icon-plus"></i> Add New</a> </h4>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="list" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th>sl #</th>
                                        <th>Page Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
                                            <td>
                                                {{$pageTypes[$page->key]}}
                                            </td>
                                            <td>
                                                @if ($page->status ==  1)
                                                    <span class='btn btn-success btn-sm'>Active</span>
                                                @else
                                                    <span class='btn btn-danger btn-sm'>In-Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a style='cursor: pointer;padding:2px;' href="{{route('page.edit',[$page->id])}}"><i class='fa fa-edit'></i> </a>
                                                <a style='cursor: pointer;padding:2px;' href="{{route('page.delete',[$page->id])}}"><i class='fa fa-trash'></i> </a>
                                                <a style='cursor: pointer;padding:2px;' target="_blank" href="{{url($page->key)}}"><i class='fa fa-eye'></i> </a>
                                            </td>
                                        </tr>


                                    @endforeach
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
            commonlist =$('#list').DataTable();
        });


    </script>
@endsection
