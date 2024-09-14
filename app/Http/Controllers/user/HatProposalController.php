<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AppDocuments;
use App\Models\AreaInfo;
use App\Models\Attachment;
use App\Models\HatProposal;
use App\Models\OwnershipType;
use App\Models\ProposalEmploymentInfo;
use App\Models\TrainingTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HatProposalController extends Controller
{

    public function index()
    {

        return view('userPanel.proposal-list');
    }

    public function create()
    {
        $attachment_list = Attachment::where('status', 1)->get();
        $trainingTrack = TrainingTrack::pluck('course_name', 'course_id')->toArray();
        $ownershipType = OwnershipType::where('status', 1)->pluck('name', 'id')->toArray();
        $district = AreaInfo::where('area_type', 2)->orderBy('area_nm','asc')->pluck('area_nm', 'area_id')->toArray();
        return view('userPanel.proposal-create', compact('district', 'ownershipType', 'trainingTrack', 'attachment_list'));
    }

    public function getList()
    {
        if(Auth::user()->user_type == 'company'){
            $data = HatProposal::where('created_by', Auth::user()->id)
                ->leftjoin('ownership_type as ot', 'ot.id', 'hat_proposal.ownership_type')
                ->orderBy('id', 'desc')
                ->get([
                    'hat_proposal.id',
                    'hat_proposal.company_name',
                    'hat_proposal.status_id',
                    'hat_proposal.ownership_type',
                    'hat_proposal.owner_contact_no',
                    'hat_proposal.owner_name',
                    'ot.name as ownership_type_name',
                ]);
        }else{
            $data = HatProposal::where('status_id','!=', '-1')
                ->leftjoin('ownership_type as ot', 'ot.id', 'hat_proposal.ownership_type')
                ->orderBy('id', 'desc')
                ->get([
                    'hat_proposal.id',
                    'hat_proposal.company_name',
                    'hat_proposal.status_id',
                    'hat_proposal.ownership_type',
                    'hat_proposal.owner_contact_no',
                    'hat_proposal.owner_name',
                    'ot.name as ownership_type_name',
                ]);
        }


        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->status_id == -1) {
                    return "<a style='cursor: pointer;padding:2px;' href='" . route('user.proposalEdit', [$data->id]) . "'><i class='fa fa-edit'></i></a>";
                } else {
                    return "<a style='cursor: pointer;padding:2px;' href='" . route('user.proposalView', [$data->id]) . "'><i class='fa fa-folder-open'></i></a>";
                }
            })
            ->addColumn('app_status', function ($data) {
                $status = '';
                if ($data->status_id == 1) {
                    $status = 'Submitted';
                } elseif ($data->status_id == 2) {
                    $status = 'Approved';

                } elseif ($data->status_id == 3) {
                    $status = 'Rejected';
                } elseif ($data->status_id == -1) {
                    $status = 'Draft';
                }
                return '<span class="label label-warning" >'.$status.'</span>';
            })
            ->rawColumns(['action', 'status','app_status'])
            ->make(true);
    }

    public function storeProposal(Request $request)
    {
        $proposalId = $request->get('proposal_id');
        if ($proposalId) {
            $proposal = HatProposal::find($proposalId);
            $proposal->updated_from = $request->ip();
        } else {
            $proposal = new HatProposal();
            $proposal->created_from = $request->ip();
        }
        if ($request->actionBtn == 'Save as Draft') {
            $proposal->status_id = -1;
        } else {
            $proposal->status_id = 1;
        }

        $proposal->company_name = $request->get('company_name');
        $proposal->district_id = $request->get('district');
        $proposal->thana_id = $request->get('thana');
        $proposal->detail_addr = $request->get('address');
        $proposal->ownership_type = $request->get('ownership_type');
        $proposal->owner_name = $request->get('owner_name');
        $proposal->owner_email = $request->get('email');
        $proposal->owner_designation = $request->get('owner_designation');
        $proposal->owner_contact_no = $request->get('phone');
        $proposal->business_description = $request->get('business_description');
        $proposal->number_of_existing_emp = $request->get('number_of_existing_emp');
        $proposal->revenue_yearly_bdt = $request->get('revenue_yearly_bdt');
        $proposal->foreign_investment = $request->get('foreign_investment');
        $proposal->local_investment = $request->get('local_investment');
        $proposal->local_investment = $request->get('local_investment');
        $proposal->expansion_plan = $request->get('expansion_plan');
        $proposal->save();

        if (!empty($request->training_track)) {
            $listOfIds = [];
            foreach ($request->training_track as $key => $value) {
                $proposalEmploymentInfo = new ProposalEmploymentInfo();
                $proposalEmploymentInfo->hat_proposal_id = $proposal->id;
                $proposalEmploymentInfo->track_id = $request->get('training_track')[$key];
                $proposalEmploymentInfo->no_of_people = $request->get('no_of_people')[$key];
                $proposalEmploymentInfo->save();
                $listOfIds[] = $proposalEmploymentInfo->id;
            }

            if (count($listOfIds) > 0) {
                ProposalEmploymentInfo::where('hat_proposal_id', $proposal->id)
                    ->whereNotIn('id', $listOfIds)
                    ->delete();
            }
        }

        // Start file uploading
        $docIds = $request->get('dynamicDocumentsId');
        //Start file uploading
        if (isset($docIds)) {
            foreach ($docIds as $doc) {
                $app_doc = AppDocuments::firstOrNew([
                    'app_id' => $proposal->id,
                    'doc_info_id' => $doc
                ]);
                $app_doc->doc_info_id = $doc;
                $app_doc->doc_name = $request->get('doc_name_' . $doc);;
                $app_doc->doc_file_path = $request->get('validate_field_' . $doc);
                $app_doc->save();
            }
        } /* End file uploading */

        return redirect()->to('/home');


    }

    public function viewProposal($id)
    {
        $appData = HatProposal::leftjoin('ownership_type as ot', 'ot.id', 'hat_proposal.ownership_type')
            ->leftJoin('area_info as company_district', 'company_district.area_id', '=', 'hat_proposal.district_id')
            ->leftJoin('area_info as company_thana', 'company_thana.area_id', '=', 'hat_proposal.thana_id')
            ->where('hat_proposal.id', $id)
            ->first([
                'hat_proposal.*',
                'company_district.area_nm as district_name',
                'company_thana.area_nm as thana_name',
                'ot.name as ownership_type_name'
            ]);
        $proposalInfo = ProposalEmploymentInfo::leftjoin('training_track as tt', 'tt.course_id', 'proposal_employment_info.track_id')
            ->where('hat_proposal_id', $appData->id)
            ->get(['proposal_employment_info.*', 'tt.course_name']);

        $documents = AppDocuments::where(['app_id' => $appData->id])->get();
        return view('userPanel.proposal-view', compact('appData', 'proposalInfo', 'documents'));
    }

    public function editProposal($id)
    {
        $appData = HatProposal::find($id);
        $proposalInfo = ProposalEmploymentInfo::where('hat_proposal_id', $appData->id)->get();
        $attachment_list = Attachment::where('status', 1)->get();
        $trainingTrack = TrainingTrack::pluck('course_name', 'course_id')->toArray();
        $ownershipType = OwnershipType::where('status', 1)->pluck('name', 'id')->toArray();
        $district = AreaInfo::where('area_type', 2)->orderBy('area_nm','asc')->pluck('area_nm', 'area_id')->toArray();
        $clr_document = AppDocuments::where(['app_id' => $appData->id])->get();

        $clrDocuments = [];

        foreach ($clr_document as $documents) {
            $clrDocuments[$documents->doc_info_id]['doucument_id'] = $documents->doc_info_id;
            $clrDocuments[$documents->doc_info_id]['file'] = $documents->doc_file_path;
            $clrDocuments[$documents->doc_info_id]['doc_name'] = $documents->doc_name;
        }
        return view('userPanel.proposal-edit', compact('district', 'ownershipType', 'trainingTrack', 'attachment_list', 'appData', 'proposalInfo', 'clrDocuments'));
    }

}
