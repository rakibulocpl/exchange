<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover ">
        <thead>
        <tr>
            <th>No.</th>
            <th colspan="6">Required Attachments</th>
            <th colspan="2">Attached file
                <span style="color:darkred; font-size:12px; ">(Attachment types: pdf. Each file can have size up to 2MB)</span>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>

        {{--                {{dd($clrDocuments)}}--}}
        @foreach($attachment_list as $row)

            <tr>
                <td>
                    <div align="center">{!! $i !!}</div>
                </td>
                <td colspan="6"  @if($row['doc_priority'] == 1 ) class="required-star" @endif>{!!  $row['doc_name'] !!}</td>
                <td colspan="2">
                    <input type="hidden" value="{!!  $row['id']!!}"
                           name="dynamicDocumentsId[]"/>
                    <input type="hidden" value="{!!   $row['doc_name'] !!}"
                           id="doc_name_<?php echo $row['id']; ?>"
                           name="doc_name_<?php echo $row['id']; ?>"/>

                    <input name="<?php echo $row['doc_name']; ?>"
                           id="<?php echo $row['id']; ?>" type="file"
                           @if($row['doc_priority'] == 1 && empty($clrDocuments[$row['id']]['file'])) class="required"
                           @endif
                           size="20"
                           onchange="uploadDocument('preview_<?php echo $row['id']; ?>', this.id, 'validate_field_<?php echo $row['id']; ?>', 0)"/>

                    @if(!empty($clrDocuments[$row['id']]))
                        <div class="save_file saved_file_{{$row['id']}}">
                            <a target="_blank" class="documentUrl" href="{{URL::to('/uploads/'.(!empty($clrDocuments[$row['id']]['file']) ?
                                                                   $clrDocuments[$row['id']]['file'] : ''))}}"
                               title="{{$row['doc_name']}}">
                                <i class="fa fa-file-pdf-o"
                                   aria-hidden="true"></i> <?php $file_name = explode('/', $clrDocuments[$row['id']]['file']); echo end($file_name); ?>
                            </a>

                            <?php if(!empty($appInfo) && Auth::user()->id == $appInfo->created_by && $viewMode != 'on') {?>
                            <a href="javascript:void(0)"
                               onclick="ConfirmDeleteFile({{ $row['doc_name'] }})">
                                                                    <span class="btn btn-xs btn-danger"><i
                                                                                class="fa fa-times"></i></span>
                            </a>
                            <?php } ?>
                        </div>
                    @endif
                    <div id="preview_<?php echo $row['id']; ?>">
                        <input type="hidden"
                               value="<?php echo !empty($clrDocuments[$row['id']]['file']) ?
                                   $clrDocuments[$row['id']]['file'] : ''?>"
                               id="validate_field_<?php echo $row['id']; ?>"
                               name="validate_field_<?php echo $row['id']; ?>"/>
                    </div>

                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
</div>