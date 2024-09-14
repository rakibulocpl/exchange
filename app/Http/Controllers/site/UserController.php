<?php

namespace App\Http\Controllers\site;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){
        return view('user.list');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'branch' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'branch' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255']
        ]);
    }

    public function getlist(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = User::whereNotIn('user_type',['customer','superman'])->get([
            'users.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')
        ]);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('user.edit',[$data->id])."'><i class='fa fa-edit'></i> </a>
                <a style='cursor: pointer;padding:2px;' href='".route('user.permission',[$data->id])."'><i class='fa fa-unlock'></i> </a>
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
        $branches = Branch::where('status',1)->pluck('name','id')->toArray();
        return view('user.add',compact('branches'));
    }

    public function edit($user_Id){
        $status = array('1'=>'Active','0'=>'In-Active');
        $user = User::find($user_Id);
        $branches = Branch::where('status',1)->pluck('name','id')->toArray();
        return view('user.edit',compact('branches','user','status'));

    }

    public function store(Request $request){
        $data = $request->all();
        $this->validator($data)->validate();
         User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'branch_id' => $data['branch'],
            'user_type' => 'vendor',
            'password' => Hash::make($data['password']),
        ]);

         return redirect()->route('user.list');
    }
    public function updateUser(Request $request){
        $data = $request->all();
        $this->validatorUpdate($data)->validate();
         User::where('id',$data['user_id'])->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'branch_id' => $data['branch'],
            'status' => $data['status']
        ]);

         return redirect()->route('user.list');
    }

    public function userPermission($user_id){
        $user = User::find($user_id);
        $user_permissions = !empty($user->permissions)?json_decode($user->permissions,true):[];

        $permissions = array(
            ['module'=>'component','feature'=>['add','edit','delete']],
            ['module'=>'deal','feature'=>['list','view','update']],
//            ['module'=>'pos','feature'=>['add','edit']],
//            ['module'=>'purchase','feature'=>['add','edit']],
//            ['module'=>'transfer','feature'=>['add','report']],
//            ['module'=>'payment','feature'=>['send','receive']],
//            ['module'=>'return','feature'=>['purchase-return','purchase-return-list','sell-return','sell-return-list']],
//            ['module'=>'product','feature'=>['add','edit','author','publisher','category','history','upload']],
//
//            ['module'=>'stock','feature'=>['all-stock','search-stock']],
//            ['module'=>'barcode','feature'=>['form']],
//            ['module'=>'account','feature'=>['create-account-head','manage-account']],
        );
        return view('user.permission',compact('user','permissions','user_permissions'));

    }

    public function userPermissionStore(Request $request){
        try{
            $user_id = $request->get('user_id');
            DB::beginTransaction();
            $user_permission = json_encode($request->except(['_token','user_id']));
            $user =User::where('id',$user_id)->update(['permissions'=>$user_permission]);
            DB::commit();
            return redirect()->route('user.list');
        }catch (\Exception $e){

        }

    }

    public function profile(){
        return view('user.profile');
    }

    public function detailsUpdate(Request $request){
//        dd($request->all());
        $user_id = Auth::user()->id;
        $userData = User::find($user_id);
        $userData->name = $request->get('name');
        $userData->save();
        Session::flash('success', "Profile update successfully Done");
        return redirect()->route('user.profile');
    }

    public function imageUpdate(Request $request){

        $user_id = Auth::user()->id;
        $userData = User::find($user_id);
        $photo = $request->file('profile_image');

        $yearMonth = date("Y") . "/" . date("m") . "/";

        $path = "uploads/".$yearMonth;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if ($request->hasFile('profile_image')) {
            $prefix = date('photo_');
            $img_file = trim(sprintf("%s", uniqid($prefix, true))) . $photo->getClientOriginalName();

            $mime_type = $photo->getClientMimeType();
            if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg' || $mime_type == 'image/png') {
                $photo->move($path, $img_file);
                $filepath= $path . '/' . $img_file;
                $userData->photo_url = $filepath;
            } else {
                \Session::flash('error', 'Company logo must be png or jpg or jpeg format');
                return redirect()->back();

            }
        }
        $userData->save();
        Session::flash('success', "Profile update successfully Done");
        return redirect()->route('user.profile');

    }

    public function passwordUpdate(Request $request){

    }


}
