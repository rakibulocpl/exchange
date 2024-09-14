@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-inverse-primary">
                    <h4 class="card-title">Branch List <a class="btn btn-warning pull-right" href="{{route('pressMedia.add')}}"><i class="icon-plus"></i> Add New</a> </h4>
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
                                    @foreach($list as $value)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$value->name}} </td>
                                            <td>
                                                @if($value->status == 1)
                                                    <span class='btn btn-success btn-sm'>Active</span>
                                                @else
                                                    <span class='btn btn-danger btn-sm'>In-Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a style='cursor: pointer;padding:2px;' href="{{route('pressMedia.edit',[$value->id])}}"><i class='fa fa-edit'></i></a>
                                            </td>
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
    </div>

@endsection
@section('footer-script')
    @include('inc/datatable-script')
    <script>



    </script>
@endsection
