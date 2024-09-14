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
                                        <h4 class="card-title">Add Holy day</h4>
                                        <form class="forms-sample" action="{{route('settings.storeholyday')}}" method="post">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            {{--                                            <div class="form-check form-check-flat">--}}
                                            {{--                                                <label class="form-check-label">--}}
                                            {{--                                                    <input type="checkbox" name="category_type" id="category_type" class="form-check-input" >--}}
                                            {{--                                                    Sub Category--}}
                                            {{--                                                </label>--}}
                                            {{--                                            </div>--}}
                                            <div class="form-group">
                                                <label for="name">Title</label>
                                                <input type="text" class="form-control" id="name" name="title"   placeholder="Title" required>
                                            </div>

                                            <div class="form-group"  id="parent_section">
                                                <label>Date</label>
                                                <input type="date" class="form-control" id="date" name="date"   placeholder="Date">
                                            </div>
                                            <div class="form-group"  id="parent_section">

                                            </div>


                                            <button type="submit" class="btn btn-success mr-2">Save</button>
                                            <a class="btn btn-light" href="{{route('setings.holydaylist')}}">Cancel</a>
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
