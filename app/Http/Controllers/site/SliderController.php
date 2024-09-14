<?php

namespace App\Http\Controllers\site;

use App\Models\Brand;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class SliderController extends Controller
{
    public  function index(){
        $sliders =  Slider::all();
        return view('slider.list',compact('sliders'));
    }

    public function add(){
        return view('slider.add');
    }

    public function store(Request $request){
        $sliderId= $request->get('slider_id');
        if(!empty($sliderId)){
            $slider =  Slider::find($sliderId);
        }else{
            $slider =  new Slider();
        }

        if ($request->hasFile('image')){
            $image = $request->file('image');
            $path = $this->checkFolder();
            $uploadResponse = $this->uploadFile($path,$image);
            if($uploadResponse['code'] == 1){
                $imagePath = $uploadResponse['path'];
                $slider->path = $imagePath;
                $slider->status = 1;
                $slider->save();
            }else{
                Session::flash('error', $uploadResponse['error']);
                return redirect()->back();
            }
        }

        Session::flash('success', "Slider addend Successfully");
        return redirect()->route('slider.list');
    }

    public function edit($id){
        $slider =  Slider::find($id);
        return view('slider.edit',compact('slider'));
    }

    public function delete($id){
        $slider =  Slider::withTrashed()->find($id);
        if($slider){
            $slider->delete();
            Session::flash('success', "Slider deleted successfully");
        }else{
            Session::flash('error', "Slider not found !!");
        }
        return redirect()->route('slider.list');
    }

    public function checkFolder(){
        $yFolder = "img/slider";
        if (!file_exists($yFolder)) {
            mkdir($yFolder, 0777, true);
            $myfile = fopen($yFolder . "/index.html", "w");
            fclose($myfile);
        }

        return $yFolder;
    }

    public function uploadFile($path,$_file){
        $prefix = 'slider';
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


}
