<?php

namespace App\Http\Controllers\site;

use App\Models\Branch;
use App\Models\PressAndMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class PressMediaController extends Controller
{
    public function index(){
        $list = PressAndMedia::all();
        return view('PressMedia.list',compact('list'));
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required'],
            'contract_no' => ['required']
        ]);
    }


    public function add(){
        return view('PressMedia.add');
    }

    public function edit($branch_Id){
        $status = array('1'=>'Active','0'=>'In-Active');
        $item = PressAndMedia::find($branch_Id);
        return view('PressMedia.edit',compact('item','status'));

    }

    public function store(Request $request){
        $data = $request->all();
        $news = array();
        foreach ($request->headline as $key=>$value){
           $news[$key]['title'] = $request->headline[$key];
            $news[$key]['link'] = $request->link[$key];
        }
        if ($request->hasFile('logo')){
            $_fontImage = $request->file('logo');
            $fileUpload = $this->uploadFile($_fontImage);
            if(is_array($fileUpload) && $fileUpload['code'] == -1){
                return redirect()->back()->withInput();
            }else{
                $logo = $fileUpload['path'];
            }
        }
        PressAndMedia::create([
            'name' => $data['name'],
            'news' => json_encode($news),
            'logo' => $logo,
            'status'=>1
        ]);

        return redirect()->route('pressMedia.list');
    }
    public function update(Request $request){
        $data = $request->all();

        $news = array();
        foreach ($request->headline as $key=>$value){
            $news[$key]['title'] = $request->headline[$key];
            $news[$key]['link'] = $request->link[$key];
        }
       $item = PressAndMedia::find($data['item_id']);
        $item->name = $data['name'];
        if ($request->hasFile('logo')){
            $_fontImage = $request->file('logo');
            $fileUpload = $this->uploadFile($_fontImage);
            if(is_array($fileUpload) && $fileUpload['code'] == -1){
                return redirect()->back()->withInput();
            }else{
                $logo = $fileUpload['path'];
            }
            $item->logo = $logo;
        }
        $item->news = $news;
        $item->save();

        return redirect()->route('pressMedia.list');
    }

    public function uploadFile($_file){
        $path = $this->checkFolder();
        $prefix = 'laptop_';
        $docBaseUrl = url('uploads');
        $i = strripos($_file->getClientOriginalName(), '.');
        $ext = strtolower(substr($_file->getClientOriginalName(), $i + 1));
        $original_file = uniqid($prefix,true) . "." . $ext;
        $file_type = $_file->getClientMimeType();
        if ($file_type == 'application/pdf') {
            return array('code'=>-1,"error"=>"invalid file type");
        }
        $authoFileUrl = $original_file;
        $_file->move($path, $authoFileUrl);
        return array('code'=>1,"path"=>$path.'/'.$authoFileUrl);
    }

    public function checkFolder(){
        $yFolder = "uploads/" . date("Y");
        if (!file_exists($yFolder)) {
            mkdir($yFolder, 0777, true);
            $myfile = fopen($yFolder . "/index.html", "w");
            fclose($myfile);
        }
        $ym = date("Y") . "/" . date("m") . "/";
        $ym1 = "uploads/" . date("Y") . "/" . date("m");
        if (!file_exists($ym1)) {
            mkdir($ym1, 0777, true);
            $myfile = fopen($ym1 . "/index.html", "w");
            fclose($myfile);
        }
        return $ym1;

    }

}
