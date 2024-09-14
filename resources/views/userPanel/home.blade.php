@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="container">
            <div class="card   my-3 p-3">
                <div id="form-header" class="text-center p-3">
                    <h2 class="font-weight-bold">Proposal for Training</h2>
                    <span class="text-muted">Please fillup required fields with proper information</span>
                </div>
                <div class="col-md-12" style="padding: 0 5% 0 5%;">
                    <form id="userRegistration" method="post" action="{{route('user.storeProposal')}}">
                        <input type="hidden" name="selected_file" id="selected_file"/>
                        <input type="hidden" name="validateFieldName" id="validateFieldName"/>
                        <input type="hidden" name="isRequired" id="isRequired"/>
                        @csrf
                        <div class="position-relative">
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto">Company info</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="company_name">Company Name </label>
                                        <input type="text" name="company_name" value="{{old('company_name')}}"
                                               class="form-control rounded required" id="company_name"/>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="district" class="required-star">District </label>
                                        {!! Form::select('district',[''=>'Select District'] +$district,old('district'), $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                                'id'=>"district")) !!}
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label for="thana" class="required-star">Thana </label>
                                        {!! Form::select('thana',[''=>'Select District First'],'', $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                                'id'=>"thana")) !!}
                                        <span class="text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="address" class="required-star">Details Address </label>
                                        <textarea class="form-control required" id="address" name="address"
                                                  placeholder="Your Details Address">{{old('address')}}</textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="revenue_yearly_bdt">Revenue Yearly (BDT) </label>
                                        <input type="text" name="revenue_yearly_bdt" value=""
                                               class="form-control rounded number required" id="revenue_yearly_bdt"/>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="foreign_investment">Foreign Investment </label>
                                        <input type="text" name="foreign_investment" value=""
                                               class="form-control rounded number required" id="foreign_investment"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="local_investment">Local Investment </label>
                                        <input type="text" name="local_investment" value=""
                                               class="form-control rounded number required" id="local_investment"/>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="number_of_existing_emp">Number of Existing Employee </label>
                                        <input type="text" name="number_of_existing_emp" value=""
                                               class="form-control rounded number required" id="number_of_existing_emp"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="business_description" class="required-star">Business Description </label>
                                        <textarea class="form-control required" id="business_description" name="business_description"
                                                  placeholder="Your Details Address">{{old('business_description')}}</textarea>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="expansion_plan" class="required-star">Expansion Plan </label>
                                        <textarea class="form-control required" id="expansion_plan" name="expansion_plan"
                                                  placeholder="Expansion Plan">{{old('expansion_plan')}}</textarea>
                                    </div>
                                </div>


                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto">Ownership info</legend>
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="name">Owner name <i
                                                    class="fa fa-question-circle" style="cursor: pointer;"
                                                    data-toggle="tooltip"
                                                    title="Owner who is in chief executive position in Company"></i></label>
                                        <input type="text" name="owner_name" value="{{Auth::user()->name}}"
                                               class="form-control rounded required" id="owner_name"/>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label class="required-star" for="owner_designation">Owner Designation </label>
                                        <input type="text" name="owner_designation" value=""
                                               class="form-control rounded required" id="owner_designation"/>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="required-star" for="phone">Contact</label>
                                        <input type="text" class="form-control bd_mobile required"
                                               value="{{Auth::user()->phone}}"
                                               id="phone" name="phone"
                                               placeholder="01xxxxxxxx" maxLength="11"/>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email" class="required-star">Email</label>
                                        <input name="email" type="email" value="{{Auth::user()->email}}"
                                               class="form-control required"
                                               id="inputEmail"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 ">
                                        <label for="district" class="required-star">Ownership Type </label>
                                        {!! Form::select('ownership_type',[''=>'Select Type'] +$ownershipType,old('ownership_type'), $attributes = array('class'=>'js-example-basic-single form-control required',
                                                                                'id'=>"ownership_type")) !!}
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto"> Proposed employment info</legend>
                                @include('userPanel/proposed_employment_info')
                            </fieldset>
                            <fieldset class="form-group border p-2">
                                <legend class="w-auto"> Attachments</legend>
                                @include('userPanel/documents')
                            </fieldset>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary  pl-4 pr-4" value="draft"
                                            name="register">
                                        <span>Draft</span>
                                    </button>
                                    <button type="submit" class="btn btn-success pl-4 pr-4 pull-right" value="submit"
                                            name="register">
                                        <span>Submit</span>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')

    <script>
        $("#district").on("change", function () {
            let districtId = $(this).val();
            $.ajax({
                url: 'info/get-thana/' + districtId,
                type: "GET",
                success: function (response) {
                    var option = '<option value="">Select Thana</option>';
                    $.each(response, function (key, row) {
                        option += '<option  value="' + row.area_id + '">' + row.area_nm + '</option>';
                    });
                    $("#thana").html(option)
                }
            });
        });

        function uploadDocument(targets, id, vField, isRequired) {
            var inputFile = $("#" + id).val();
            if (inputFile == '') {
                $("#" + id).html('');
                document.getElementById("isRequired").value = '';
                document.getElementById("selected_file").value = '';
                document.getElementById("validateFieldName").value = '';
                document.getElementById(targets).innerHTML = '<input type="hidden" class="required" value="" id="' + vField + '" name="' + vField + '">';
                if ($('#label_' + id).length)
                    $('#label_' + id).remove();
                return false;
            }

            try {

                document.getElementById("isRequired").value = isRequired;
                document.getElementById("selected_file").value = id;
                document.getElementById("validateFieldName").value = vField;
                document.getElementById(targets).style.color = "red";
                var action = "{{route('user.uploadDoc')}}";
                // alert(action);
                $("#" + targets).html('Uploading....');
                var file_data = $("#" + id).prop('files')[0];
                var form_data = new FormData();
                form_data.append('selected_file', id);
                form_data.append('isRequired', isRequired);
                form_data.append('validateFieldName', vField);
                form_data.append('_token', "{{ csrf_token() }}");
                form_data.append(id, file_data);
                $.ajax({
                    target: '#' + targets,
                    url: action,
                    dataType: 'text', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (response) {
                        $('#' + targets).html(response);
                        var fileNameArr = inputFile.split("\\");
                        var l = fileNameArr.length;
                        if ($('#label_' + id).length)
                            $('#label_' + id).remove();
                        var doc_id = id;
                        var newInput = $('<label class="saved_file_' + doc_id + '" id="label_' + id + '"><br/><b>File: ' + fileNameArr[l - 1] + ' <a href="javascript:void(0)" class="filedelete" docid="' + id + '" ><span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span> </a></b></label>');
//                        var newInput = $('<label id="label_' + id + '"><br/><b>File: ' + fileNameArr[l - 1] + '</b></label>');
                        $("#" + id).after(newInput);
                        $('#' + id).removeClass('required');
                        //check valid data
                        document.getElementById(id).value = '';
                        var validate_field = $('#' + vField).val();
                        if (validate_field == '') {
                            document.getElementById(id).value = '';
                        }
                    }
                });
            } catch (err) {
                document.getElementById(targets).innerHTML = "Sorry! Something Wrong.";
            }
        }

        $(document).on('click', '.filedelete', function () {
            var abc = $(this).attr('docid');
            var sure_del = confirm("Are you sure you want to delete this file?");
            if (sure_del) {
                document.getElementById("validate_field_" + abc).value = '';
                document.getElementById(abc).value = '';
                $('.saved_file_' + abc).html('');
                $('.span_validate_field_' + abc).html('');
            } else {
                return false;
            }
        });

        $("#userRegistration").validate({
            errorPlacement: function () {
                return true;
            }
        });
    </script>
@endsection