@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-inverse-primary">
                    <h4 class="card-title">Permission For <strong class="text-white">{{$user->name}}</strong>  </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="list" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th width="20%">Module</th>
                                        <th width="80%" class="text-center">Permissions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <form action="{{route('user.permissionStore')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{$user->id}}">

                                        @foreach($permissions as $permission)
                                        <tr>
                                            <td>{{$data = $permission['module']}}</td>
                                            <td class="text-left">
                                            @foreach($permission['feature'] as $value)

                                                @if(array_key_exists($data,$user_permissions))
                                                    @if(in_array($value,$user_permissions[$data]))
                                                            <label style="padding: 2px">
                                                                <input type="checkbox" checked name="{{$permission['module']}}[]" value="{{$value}}" style="margin-right: 2px">{{$value}}
                                                            </label>
                                                    @else
                                                            <label style="padding: 2px">
                                                                <input type="checkbox" name="{{$permission['module']}}[]" value="{{$value}}" style="margin-right: 2px">{{str_replace('-',' ',$value)}}
                                                            </label>
                                                    @endif
                                               @else
                                                       <label style="padding: 2px">
                                                           <input type="checkbox" name="{{$permission['module']}}[]" value="{{$value}}" style="margin-right: 2px">{{$value}}
                                                       </label>
                                                @endif
                                            @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Submit') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </form>
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
                    <span id="commonmodalTitle">Edit Product</span>
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

    </script>
@endsection
