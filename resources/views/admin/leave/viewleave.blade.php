@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Leave Details</h4>



                                            <div class="form-group">
                                                <label>Name:  {{$employee->name}}</label>

                                            </div>

                                            <div class="form-group"  >
                                                <label>Date: {{\Carbon\Carbon::parse($leave->date_form)->format('d-M-Y').' to '. \Carbon\Carbon::parse($leave->date_to)->format('d-M-Y')}}</label>

                                            </div>
                                            <div id="affected_date">

                                            </div>
                                            <div class="form-group"  >
                                                <label>No of Days: {{$leave->no_of_days.' Days'}}</label>


                                                <div class="form-group"  >
                                                    <label>Reason : {{$leave->reason}}</label>

                                                </div>

                                                <div class="form-group"  >
                                                    <?php $status = [0=>'Pending','1'=>'Approved']; ?>
                                                    <label>Status: <span class="{{$leave->status ==1?'text-success':'text-danger'}}">{{$status[$leave->status]}}</span></label>

                                                </div>

                                                <a class="btn btn-light" href="{{route('leave.list')}}">back</a>
                                                <button type="submit" class="btn btn-success mr-2">Edit</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Employee Leave history</h4>

                                            <div class="form-group"  >
                                                <label>Employee Id: <b><a href="{{route('employee.show',['employee'=>$employee->id])}}">{{$employee->emp_id}}</a></b></label>
                                            </div>
                                            <h5 class="card-title">Lase 5 Leave</h5>
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>No of Days</th>
                                                </tr>
                                               @foreach($previous_leave as $value)
                                                  <tr>
                                                      <td>{{$value['date_form']}} to {{$value['date_to']}}</td>
                                                      <td>{{$value['no_of_days']}}</td>
                                                  </tr>
                                                   @endforeach
                                            </table>


                                        </div>
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
