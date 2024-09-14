@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categories <a class="btn btn-light pull-right" href="{{route('categories.create')}}"><i class="fa fa-plus"></i>New</a></h4>

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
                                <table id="category-list" class="table" cellspacing="0" width="100%">
                                    <thead>
                                    <tr class="bg-primary text-white">
                                        <th>sl #</th>
                                        <th>Category name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activeCategories as $category)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$category->name}}</td>
                                            <td><a class="btn btn-sm btn-info" href="{{route('categories.edit',[$category->id])}}">edit</a> </td>
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

