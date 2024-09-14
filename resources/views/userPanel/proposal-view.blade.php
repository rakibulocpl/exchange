@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="container">
            <div class="card   my-3 p-3">
                <div id="form-header" class="text-center p-3">
                    <h2 class="font-weight-bold">Proposal submission for Hire & Train Program</h2>
                    <p class="text-center bold-text text-info">
                        Application Status:
                        @if($appData->status_id == 1)
                            Submitted
                        @elseif($appData->status_id == 2)
                            Approved

                        @elseif($appData->status_id == 3)
                            Rejected

                        @elseif($appData->status_id == 4)
                            Approved
                        @endif
                    </p>
                </div>
                <div class="col-md-12" style="padding: 0 5% 0 5%;">
                    <form id="userRegistration" method="post" action="{{route('user.storeProposal')}}">
                        <div class="position-relative">
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto">Company info</legend>
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-12">
                                                <span class="v_label">Company Name</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->company_name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <span class="v_label">District</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->district_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Thana</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->thana_name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <span class="v_label">Details Address</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->detail_addr}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Revenue Yearly (BDT)</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->revenue_yearly_bdt}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <span class="v_label">Foreign Investment(BDT)</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->foreign_investment}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Local Investment (BDT)</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->local_investment}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <span class="v_label">Number of Existing Employee</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->number_of_existing_emp}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Business Description</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->business_description}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <span class="v_label">Expansion Plan</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->expansion_plan}}
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto">Ownership info</legend>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Owner name</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->owner_name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <span class="v_label">Owner Designation</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->owner_designation}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Contact</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->owner_contact_no}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <span class="v_label">Email</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                {{$appData->owner_email}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5 col-xs-6">
                                                <span class="v_label">Ownership Type</span>
                                                <span class="pull-right">:</span>
                                            </div>
                                            <div class="col-md-7 col-xs-6">
                                                {{$appData->ownership_type_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto"> Proposed employment info</legend>
                                <div id="ownerTable">
                                    <table id="ownerInfo" class="table table-bordered table-hover"
                                           style="overflow-x: auto;white-space: nowrap;">
                                        <thead>
                                        <tr>
                                            <th class="text-center" width="5%">SL#</th>
                                            <th class="text-center" width="45%">Training track</th>
                                            <th class="text-center" width="45%">Number Of People</th>
                                        </tr>
                                        </thead>
                                        <tbody id="owner_body">
                                        @if(count($proposalInfo)>0)
                                            <?php
                                                $i = 1;
                                                ?>
                                            @foreach($proposalInfo as $key => $value)
                                                <tr >
                                                    <td class="text-center">
                                                      {{$i}}
                                                    </td>
                                                    <td class="text-center">
                                                       {{$value->course_name}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$value->no_of_people}}
                                                    </td>
                                                </tr>
                                                <?php $i++;
                                                    ?>

                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto"> Attachments</legend>
                                <div class=" col-md-12">
                                    <table class="table table-bordered table-hover" id="loadDetails">
                                        <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Document Name</th>
                                            <th class="text-center">File</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1;?>
                                        @foreach($documents as $key => $value)
                                            @if(!empty($value->doc_file_path))
                                                <tr>
                                                    <td>{{$i}} .</td>
                                                    <td>{{$value->doc_name}}</td>
                                                    <td class="text-center">
                                                        <a target="_blank" class="btn btn-xs btn-primary"
                                                           href="{{URL::to('/uploads/'.$value->doc_file_path)}}"
                                                           title="Other File {{$key+1}}">
                                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                            Open File
                                                        </a>
                                                    </td>
                                                </tr>
                                                    <?php $i++;?>
                                            @endif

                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection