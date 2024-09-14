@extends('layouts.user')
@section('meta_title')
    {{ $page->meta_title??'' }}
@endsection
@section('meta_description')
    {{ $page->meta_description??'' }}
@endsection
@section('content')
    <div class="container">
        <div class="col-md-12 p-2 ">
            {!! $page->page_details??'' !!}
        </div>
    </div>
@endsection