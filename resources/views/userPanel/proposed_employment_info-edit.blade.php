<div id="ownerTable">
    <table id="ownerInfo" class="table table-bordered table-hover"
           style="overflow-x: auto;white-space: nowrap;">
        <thead>
        <tr>
            <th class="text-center" width="45%">Training track</th>
            <th class="text-center" width="45%">Number Of People</th>
            <th class="text-center" width="10%">Action</th>
        </tr>
        </thead>
        <tbody id="owner_body">
        <?php
        $i = 1;
        $inc = 0;

        ?>
        @if(count($proposalInfo)>0)
            @foreach($proposalInfo as $key => $value)
                    <?php
                    $gkey = ($key + 1);
                    ?>
                <tr id="ownerInfoRow{{$inc}}">
                    <td class="text-center">
                        {!! Form::select('training_track['.$inc.']',$trainingTrack,$value->track_id,['class' => 'form-control input-md owner_designation required','placeholder' => 'Select One','id'=>'owner_designation_'.$gkey]) !!}
                        {!! $errors->first('','<span class="help-block">:message</span>') !!}
                    </td>
                    <td class="text-center">
                        {!! Form::text('no_of_people['.$inc.']',$value->no_of_people,['class' => ' form-control input-md number required','id'=>'no_of_people_'.$gkey,'placeholder' => '']) !!}
                        {!! $errors->first('e_tin','<span class="help-block">:message</span>') !!}
                    </td>
                    <td style="vertical-align: middle; text-align: center">
                            <?php if ($inc == 0) { ?>
                        <a class="btn btn-sm btn-primary addTableRows"
                           onclick="addTableRowSectionK('owner_body', 'ownerInfoRow{{$inc}}');"><i
                                    class="fa fa-plus"></i></a>
                        <?php } else { ?>
                        {{--                            @if($viewMode != 'on')--}}
                        <a href="javascript:void(0);"
                           class="btn btn-sm btn-danger removeRow"
                           onclick="removeTableRow('owner_body','ownerInfoRow{{$inc}}');">
                            <i class="fa fa-times" aria-hidden="true"></i></a>
                        {{--                            @endif--}}
                        <?php } ?>
                    </td>
                </tr>
                    <?php $inc++; ?>
            @endforeach
        @else
            <tr id="ownerInfoRow{{$inc}}">
                <td class="text-center">
                    {!! Form::select('training_track[0]',$trainingTrack,null,['class' => 'form-control input-md owner_designation required','placeholder' => 'Select One','id'=>'owner_designation_1']) !!}
                    {!! $errors->first('','<span class="help-block">:message</span>') !!}
                </td>
                <td class="text-center">
                    {!! Form::text('no_of_people[0]','',['class' => ' form-control input-md number required','id'=>'no_of_people_1','placeholder' => '']) !!}
                    {!! $errors->first('e_tin','<span class="help-block">:message</span>') !!}
                </td>
                <td style="vertical-align: middle; text-align: center">
                    <a class="btn btn-sm btn-primary addTableRows"
                       title="Add more"
                       onclick="addTableRowSectionK('owner_body', 'ownerInfoRow');">
                        <i class="fa fa-plus"></i></a>
                </td>
            </tr>
        @endif


        </tbody>
    </table>
</div>

<script>

    // Add table Row script
    function addTableRowSectionK(tableID, templateRow) {
        //rowCount++;
        //Direct Copy a row to many times
        var x = document.getElementById(templateRow).cloneNode(true);
        x.id = "";
        x.style.display = "";
        var table = document.getElementById(tableID);
        var rowCount = $('#' + tableID).find('tr').length - 1;
        var lastTr = $('#' + tableID).find('tr').last().attr('data-number');
        // var production_desc_val = $('#' + tableID).find('tr').last().find('.production_desc_1st').val();
        if (lastTr != '' && typeof lastTr !== "undefined") {
            rowCount = parseInt(lastTr) + 1;
        }
        //var rowCount = table.rows.length;
        //Increment id
        var rowCo = rowCount + 2;
        var nameRo = rowCo - 1;
        var idText = 'rowCount' + tableID + rowCo;
        x.id = idText;
        $("#" + tableID).append(x);
        //get select box elements
        var attrSel = $("#" + tableID).find('#' + idText).find('select');
        //edited by ishrat to solve select box id auto increment related bug
        for (var i = 0; i < attrSel.length; i++) {
            var nameAtt = attrSel[i].name;
            var selectId = attrSel[i].id;
            var repText = nameAtt.replace('[0]', '[' + nameRo + ']'); //increment all array element name
            var ret = selectId.replace('_1', '');
            var repTextId = ret + '_' + rowCo;
            attrSel[i].id = repTextId;
            attrSel[i].name = repText;
        }
        attrSel.val(''); //value reset
        // end of  solving issue related select box id auto increment related bug by ishrat

        //get input elements
        var attrInput = $("#" + tableID).find('#' + idText).find('input');
        for (var i = 0; i < attrInput.length; i++) {
            var nameAtt = attrInput[i].name;
            var inputId = attrInput[i].id;
            var repText = nameAtt.replace('[0]', '[' + nameRo + ']'); //increment all array element name
            var ret = inputId.replace('_1', '');
            var repTextId = ret + '_' + rowCo;
            attrInput[i].id = repTextId;
            attrInput[i].name = repText;
        }
        attrInput.val(''); //value reset
        //edited by ishrat to solve textarea id auto increment related bug
        //get textarea elements
        var attrTextarea = $("#" + tableID).find('#' + idText).find('textarea');
        for (var i = 0; i < attrTextarea.length; i++) {
            var nameAtt = attrTextarea[i].name;
            //increment all array element name
            var repText = nameAtt.replace('[0]', '[' + nameRo + ']');
            attrTextarea[i].name = repText;
            $('#' + idText).find('.readonlyClass').prop('readonly', true);
        }
        attrTextarea.val(''); //value reset
        // end of  solving issue related textarea id auto increment related bug by ishrat
        attrSel.prop('selectedIndex', 0);
        if ((tableID === 'machinaryTbl' && templateRow === 'rowMachineCount0') || (tableID === 'machinaryTbl' && templateRow === 'rowMachineCount')) {
            $("#" + tableID).find('#' + idText).find('select.m_currency').val("107");  //selected index reset
        } else {
            attrSel.prop('selectedIndex', 0);  //selected index reset
        }
        //$('.m_currency ').prop('selectedIndex', 102);
        //Class change by btn-danger to btn-primary
        $("#" + tableID).find('#' + idText).find('.addTableRows').removeClass('btn-primary').addClass('btn-danger')
            .attr('onclick', 'removeTableRow("' + tableID + '","' + idText + '")');
        $("#" + tableID).find('#' + idText).find('.addTableRows > .fa').removeClass('fa-plus').addClass('fa-times');
        $('#' + tableID).find('tr').last().attr('data-number', rowCount);

        $('.owner_nationality').select2();
        $("#" + tableID).find('#' + idText).find('.onlyNumber').on('keydown', function (e) {
            //period decimal
            if ((e.which >= 48 && e.which <= 57)
                //numpad decimal
                || (e.which >= 96 && e.which <= 105)
                // Allow: backspace, delete, tab, escape, enter and .
                || $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
                // Allow: Ctrl+A
                || (e.keyCode == 65 && e.ctrlKey === true)
                // Allow: Ctrl+C
                || (e.keyCode == 67 && e.ctrlKey === true)
                // Allow: Ctrl+V
                || (e.keyCode == 86 && e.ctrlKey === true)
                // Allow: Ctrl+X
                || (e.keyCode == 88 && e.ctrlKey === true)
                // Allow: home, end, left, right
                || (e.keyCode >= 35 && e.keyCode <= 39)) {
                var $this = $(this);
                setTimeout(function () {
                    $this.val($this.val().replace(/[^0-9.]/g, ''));
                }, 4);
                var thisVal = $(this).val();
                if (thisVal.indexOf(".") != -1 && e.key == '.') {
                    return false;
                }
                $(this).removeClass('error');
                return true;
            } else {
                $(this).addClass('error');
                return false;
            }
        }).on('paste', function (e) {
            var $this = $(this);
            setTimeout(function () {
                $this.val($this.val().replace(/[^.0-9]/g, ''));
            }, 4);
        });


    } // end of addTableRowTraHis() function

    // Remove Table row script
    function removeTableRow(tableID, removeNum) {
        $('#' + tableID).find('#' + removeNum).remove();
    }
</script>