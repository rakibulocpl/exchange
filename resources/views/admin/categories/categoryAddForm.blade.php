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
                                        <h4 class="card-title">New Category</h4>
                                        <form class="forms-sample" action="{{route('categories.store')}}" method="post">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            <div class="form-check form-check-flat">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="category_type" id="category_type" class="form-check-input" >
                                                        Sub Category
                                                </label>
                                            </div>
                                            <div class="form-group" style="display: none;" id="parent_section">
                                                <label>Parent Category</label>
                                                <select class="js-example-basic-single" name="parent_id" id="parent_category" style="width:100%">
                                                    <option value="">Select Category</option>
                                                    @foreach($activeCategories as $id=>$category)
                                                    <option value="{{$id}}">{{$category}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                                            </div>

                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <button class="btn btn-light">Cancel</button>
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
    <script>
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
