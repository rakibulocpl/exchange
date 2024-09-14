<?php

namespace App\Http\Controllers\site;

use App\Models\Brand;
use App\Models\ElectronicComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public  function index(){
        return view('brand.list');
    }
    public function getlist(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = Brand::get([
            'brands.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')
        ]);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('brand.edit',[$data->id])."'><i class='fa fa-edit'></i> </a>
                <a style='cursor: pointer;padding:2px;' href='".route('brand.delete',[$data->id])."'><i class='fa fa-trash'></i> </a>
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
        return view('brand.add');
    }

    public function store(Request $request){
        $brandId= $request->get('brand_id');
        if(!empty($brandId)){
            $brand =  Brand::find($brandId);
        }else{
            $brand =  new Brand();
        }

        $brand->name = $request->name;
        $brand->save();
        Session::flash('success', "Brand addend Successfully");
        return redirect()->route('brand.list');
    }

    public function edit($id){
        $brand =  Brand::find($id);
        return view('brand.edit',compact('brand'));
    }

    public function delete($id){
        $brand =  Brand::withTrashed()->find($id);
        if($brand){
            $brand->delete();
            Session::flash('success', "Brand deleted successfully");
        }else{
            Session::flash('error', "Brand not found !!");
        }
        return redirect()->route('brand.list');
    }


}
