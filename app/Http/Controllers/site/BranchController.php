<?php

namespace App\Http\Controllers\site;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    public function index(){
        return view('branch.list');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'contract_no' => ['required']
        ]);
    }

    public function getlist(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = Branch::get([
            'branch.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')
        ]);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('branch.edit',[$data->id])."'><i class='fa fa-edit'></i> </a>
                <a style='cursor: pointer;padding:2px;' href='".route('branch.view',[$data->id])."'><i class='fa fa-unlock'></i> </a>
                ";
            })
            ->editColumn('status', function ($data) {
                if ($data->status ==  1){
                    return "<span class='btn btn-success btn-sm'>Active</span>";
                }else{
                    return "<span class='btn btn-danger btn-sm'>In-Active</span>";
                }


            })
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function add(){
        return view('branch.add');
    }

    public function edit($branch_Id){
        $status = array('1'=>'Active','0'=>'In-Active');
        $branch = Branch::find($branch_Id);
        return view('branch.edit',compact('branch','status'));

    }

    public function store(Request $request){
        $data = $request->all();
        $this->validator($data)->validate();
        if(!empty($request->get('is_head_office'))){
            $branches = Branch::where('is_head_office',1)->count();
            if($branches >0){
                Session::flash('error', "Head office is already exists !! ");
                return redirect()->back()->withInput();
            }
        }
        Branch::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'contract_no' => $data['contract_no'],
            'email' => $data['email'],
            'is_head_office' => !empty($request->get('is_head_office'))?$request->get('is_head_office'):0
        ]);

        return redirect()->route('branch.list');
    }
    public function updateUser(Request $request){
        $data = $request->all();
        $this->validator($data)->validate();

        if(!empty($request->get('is_head_office'))){
            $branches = Branch::where('is_head_office',1)->count();
            if($branches >0){
                Session::flash('error', "Head office is already exists !! ");
                return redirect()->back()->withInput();
            }
        }
        Branch::where('id',$data['branch_id'])->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'contract_no' => $data['contract_no'],
            'email' => $data['email'],
            'is_head_office' => $request->get('is_head_office')
        ]);

        return redirect()->route('branch.list');
    }

}
