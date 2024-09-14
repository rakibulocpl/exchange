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
                                        <h4 class="card-title">Insert Employee log</h4>
                                        <form class="forms-sample" action="{{route('attendance.insertlogbydate')}}" method="post" >
                                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                                            <div class="form-group"  id="parent_section">
                                                <label>Date</label>
                                                <input type="date" class="form-control" id="date" name="att_date"   placeholder="Date" required>
                                            </div>
                                            <a class="btn btn-light" href="{{route('dashboard.index')}}">Cancel</a>
                                            <button type="submit" class="btn btn-success mr-2">Save</button>
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
@endsection
