@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-inverse-primary">{{ __('Add New Component Item') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('component.update') }}">
                            @csrf
                            <input type="hidden" name="item_id" value="{{$item->id}}">

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Component') }}</label>

                                <div class="col-md-6">
                                    {!! Form::select('component',[''=>'Select Component'] +$component,$item->component_id, $attributes = array('class'=>'js-example-basic-single form-control',
                                                               'id'=>"component")) !!}
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Details') }}</label>

                                <div class="col-md-6">
                                    <input id="details" type="text" class="form-control @error('details') is-invalid @enderror" name="details" value="{{ $item->details }}" required autocomplete="details" autofocus>

                                    @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $item->addition_price }}" required autocomplete="price" autofocus>

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
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