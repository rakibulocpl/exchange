@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-inverse-primary">{{ __('Edit Product') }}</div>
                    <div class="card-body">
                        <form id="productForm" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input id="name" type="text" class="form-control required @error('name') is-invalid @enderror" name="name" value="{{$product->product_name}}"   autocomplete="name"  >
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Category</label>
                                    {!! Form::select('category_id', $category,$product->category_id,['class' => 'form-control input-md required','id'=>'category_id']) !!}
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Product Code</label>
                                    <input id="product_code" type="text" class="form-control required" name="product_code" value="{{$product->product_code}}"/>

                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Price</label>
                                    <input id="price" type="text" class="form-control require" name="price" value="{{$product->price}}"   autocomplete="name"  >

                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input id="meta_title" type="text" class="form-control" name="meta_title" value="{{ $product->meta_title }}"  >
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description">{{ $product->meta_description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="brand" class="form-label">Brand</label>
                                    {!! Form::select('brand', $brands,$product->brand_id,['class' => 'form-control input-md required','id'=>'brand']) !!}
                                </div>
                                <div class="col-md-6">
                                    <label for="model" class="form-label">Model</label>
                                    <input id="model" type="text" class="form-control required @error('model') is-invalid @enderror" name="model" value="{{$product->model}}"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Images</label>
                                    <input type="file" class="form-control" name="images[]" multiple>
                                </div>
                                <div class="col-md-6">
                                    <label for="brand" class="form-label">Product Type</label>
                                    {!! Form::select('publish', ['0'=>'Unpublished','1'=>'Publish'],$product->is_published,['class' => 'form-control input-md required','id'=>'publish']) !!}
                                </div>
                            </div>
                            <div class="row mb-5">
                                @foreach($product->images as $image)
                                    <div class="col-md-3">
                                        <a class="btn btn-danger btn-xs mb-2" href="{{route('product.imageDelete',[$image->id])}}">Delete</a>
                                        <img class="img-fluid img-thumbnail" src="{{asset($image->path)}}"/>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control required textEditor" id="short_description">{!! $product->short_description !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Full Description</label>
                                    <textarea name="description" class="form-control required textEditor" id="description">{!! $product->description !!}</textarea>
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
    <script src="{{asset('/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js" integrity="sha512-lLE5tUMZXmDmyGWI5KDlFemVusXiALcU1lPibL4xkPbPvuOXfXcdoeU3KBDxWp18/KOzrfKkgsscN1t9740ciA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '.textEditor',
            plugins: 'link image table lists',
            toolbar: 'undo bullist redo | bold italic | alignleft aligncenter alignright | link image table',
            menubar: 'file edit insert view format table tools help'
        });
        $('#productForm').validate({
            errorPlacement: function () {
                return false;
            }
        });

    </script>
@endsection