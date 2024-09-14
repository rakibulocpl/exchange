@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-inverse-primary">{{ __('Add New Page') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('page.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label for="brand" class="form-label">Page</label>
                                    {!! Form::select('key', $pages,'',['class' => 'form-control input-md required','id'=>'key']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="brand" class="form-label">Meta Title</label>
                                    <textarea name="meta_title" class="form-control" id="meta_title"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="brand" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Short Description</label>
                                    <textarea name="page_details" class="form-control required textEditor" id="page_details"></textarea>
                                </div>
                            </div>
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
    <script src="{{asset('/vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js" integrity="sha512-lLE5tUMZXmDmyGWI5KDlFemVusXiALcU1lPibL4xkPbPvuOXfXcdoeU3KBDxWp18/KOzrfKkgsscN1t9740ciA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '.textEditor',
            plugins: 'link image table lists advcode',
            toolbar: 'undo bullist redo | bold italic | alignleft aligncenter alignright | link image table',
            menubar: 'file edit insert view format table tools help code'
        });
        $('#productForm').validate({
            errorPlacement: function () {
                return false;
            }
        });

    </script>
@endsection