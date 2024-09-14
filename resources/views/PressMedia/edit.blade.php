@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-inverse-primary">{{ __('Edit Media Item') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pressMedia.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="item_id" value="{{$item->id}}">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Media Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$item->name}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-left">{{ __('Logo') }}</label>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="logo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-left"></label>

                                <div class="col-md-6">
                                   <img src="/{{$item->logo}}" height="70px" style="width: 100%">
                                </div>
                            </div>

                            <fieldset class="form-group border p-2">
                                <legend class="w-auto">News List</legend>
                                @include('PressMedia/news-edit',$item)
                            </fieldset>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script>

    </script>
@endsection