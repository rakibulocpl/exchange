@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Edit Category</h4>
                                        <form class="forms-sample" action="{{route('categories.update',['category'=>$category->id])}}" method="post" enctype="multipart/form-data">
                                            {{method_field('put')}}
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            @if($category->parent_id !=0)
                                            <div class="form-group"  id="parent_section">
                                                <label>Parent Category</label>
                                                {!! Form::select('parent_id',[''=>'Select Category'] +$activeCategories, $category->parent_id, $attributes = array('class'=>'js-example-basic-single form-control',
                           'id'=>"parent_category")) !!}
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="exampleInputName1">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$category->name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Slug</label>
                                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{$category->slug}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Meta Title</label>
                                                <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Meta title" value="{{$category->meta_title}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Meta Description</label>
                                                <textarea name="meta_description" class="form-control" id="meta_description">
                                                    {!! $category->meta_description !!}
                                                </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputName1">Category Details</label>
                                                <textarea name="category_details" class="form-control textEditor" id="category_details">
                                                    {!! $category->category_details !!}
                                                </textarea>
                                            </div>
                                            <div class="form-group row">
                                                <label for="image" class="form-label">Images</label>
                                                <input type="file" class="form-control" name="image" >
                                            </div>
                                            <div class="row">
                                                <img class="img-thumbnail" style="height: 120px;width: 120px"     src="{{asset($category->image)}}"/>
                                            </div>
                                            <div class="row mt-4">
                                                <button type="submit" class="btn btn-success mr-2">Update</button>
                                                <a class="btn btn-light" href="{{route('categories.index')}}">Cancel</a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js" integrity="sha512-lLE5tUMZXmDmyGWI5KDlFemVusXiALcU1lPibL4xkPbPvuOXfXcdoeU3KBDxWp18/KOzrfKkgsscN1t9740ciA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '.textEditor',
            plugins: 'link image table lists',
            toolbar: 'undo bullist redo | bold italic | alignleft aligncenter alignright | link image table',
            menubar: 'file edit insert view format table tools help'
        });
        $('#category_type').on('change',function () {
            if ($(this).is(':checked')){
                $('#parent_section').slideDown();
            }else{
                $('#parent_category').val('');
                $('#parent_section').slideUp();
            }
        });
    </script>
@endsection
