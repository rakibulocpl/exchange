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
                                        <h4 class="card-title">New Product</h4>
                                        <form class="forms-sample" action="{{route('employee.store')}}" method="post">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            {{--                                            <div class="form-check form-check-flat">--}}
                                            {{--                                                <label class="form-check-label">--}}
                                            {{--                                                    <input type="checkbox" name="category_type" id="category_type" class="form-check-input" >--}}
                                            {{--                                                    Sub Category--}}
                                            {{--                                                </label>--}}
                                            {{--                                            </div>--}}


                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"   placeholder="Name">
                                            </div>

                                            <div class="form-group"  id="parent_section">
                                                <label>Position</label>
                                                {!! Form::select('position_id',[''=>'Select Position','1'=>'Manager','2'=>'Asst Manager'], '', $attributes = array('class'=>'js-example-basic-single form-control',
                           'id'=>"position_id")) !!}
                                            </div>
                                            <div class="form-group"  id="parent_section">
                                                <label>Status</label>
                                                {!! Form::select('status',[0=>'In-Active','1'=>'Active'],'', $attributes = array('class'=>'js-example-basic-single form-control',
                           'id'=>"parent_category")) !!}
                                            </div>


                                            <button type="submit" class="btn btn-success mr-2">Update</button>
                                            <a class="btn btn-light" href="{{route('employee.list')}}">Cancel</a>
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
