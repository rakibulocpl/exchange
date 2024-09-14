<?php

namespace App\Http\Controllers\site;

use App\Models\Brand;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\DealChat;
use App\Models\ImageGallery;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    public function index(Request $request){
        return view('product.list');
    }

    public function getlist(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = Product::get([
            'products.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')
        ]);

        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addColumn('action', function ($data) {
                return "
                <a style='cursor: pointer;padding:2px;' href='".route('product.edit',[$data->id])."'><i class='fa fa-edit'></i> </a>
                <a style='cursor: pointer;padding:2px;' href='".route('product.view',[$data->id])."'><i class='fa fa-folder-open'></i> </a>
                <a style='cursor: pointer;padding:2px;' href='".route('product.delete',[$data->id])."'><i class='fa fa-trash'></i> </a>
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

    public function create(){
        $data['category'] = [''=>'Select Category']+Category::pluck('name','id')->toArray();
        $data['brands'] =[''=>'Select Brand']+ Brand::where('status',1)->pluck('name','id')->toArray();
        return view('product.add',$data);
    }

    public function store(Request  $request){
        $productId = $request->get('product_id');
        try {
            $product = Product::firstOrNew(['id'=>$productId]);
            $product->product_name = $request->get('name');
            $product->product_code = $request->get('product_code');
            $product->category_id = $request->get('category_id');
            $product->model = $request->get('model');
            $product->brand_id = $request->get('brand');
            $product->short_description = $request->get('short_description');
            $product->description = $request->get('description');
            $product->price = $request->get('price');
            $product->is_published = $request->get('publish');
            $product->status = 1;
            $product->meta_title = $request->get('meta_title');
            $product->meta_description = $request->get('meta_description');
            $product->save();
            if ($request->hasFile('images')) {
                $path = $this->checkFolder();
                foreach ($request->file('images') as $key => $image) {
                    $uploadResponse = $this->uploadFile($path,$image);
                    if($uploadResponse['code'] == 1){
                        $imagePath = $uploadResponse['path'];
                        $imageGallery = new ImageGallery();
                        $imageGallery->product_id = $product->id;
                        $imageGallery->path = $imagePath;
                        $imageGallery->save();
                        if ($key == 0){
                            $product->thumbnail =  $imageGallery->path;
                            $product->save();
                        }
                    }else{
                        Session::flash('error', $uploadResponse['error']);
                        return redirect()->back();
                    }
                }
            }
            Session::flash('success', "Product Added Successfully");
            return redirect()->route('product.list');
        }catch (\Exception $e){
            dd($e->getMessage());
        }


    }
    public function edit($id){
        $data['brands'] = [''=>'Select Brand']+ Brand::where('status',1)->pluck('name','id')->toArray();
        $data['product'] = Product::with('images')->find($id);
        $data['category'] = [''=>'Select Category']+Category::pluck('name','id')->toArray();

        return view('product.edit',$data);
    }
   

    public function view($id){
        $product = Product::with('images')->find($id);
        return view('product.view',compact('product'));
    }

    public function delete($id){
        $brand =  Brand::withTrashed()->find($id);
        if($brand){
            $brand->delete();
            Session::flash('success', "Brand deleted successfully");
        }else{
            Session::flash('error', "Brand not found !!");
        }
        return redirect()->route('product.list');
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

    public function uploadFile($path,$_file){
        $prefix = 'product_';
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
    public function imageDelete($imageId){
        $image = ImageGallery::where('id',$imageId)->first();
        File::delete($image->path);
        $image->delete();
        return redirect()->back();
    }
}
