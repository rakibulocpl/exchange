<?php

namespace App\Http\Controllers\site;

use App\Models\Brand;
use App\Models\ComponentDetails;
use App\Models\ElectronicComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Component;
use Yajra\DataTables\Facades\DataTables;

class ComponentController extends Controller
{
    public  function index(){

       return view('component.list');
    }


    public function getlist(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = ElectronicComponent::get([
            'electronics_components.*',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')
        ]);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('component.itemEdit',[$data->id])."'><i class='fa fa-edit'></i> </a>
          
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
    public function item(){
        return view('component.itemList');
    }
    public function getItemList(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = ComponentDetails::leftjoin('electronics_components as ec','component_details.component_id','ec.id')
        ->get([
            'component_details.*',
            'ec.component_name',
            DB::raw('@rownum  := @rownum  + 1 AS rownum')
        ]);
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('component.itemEdit',[$data->id])."'><i class='fa fa-edit'></i> </a>
            
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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'component' => ['required'],
            'details' => ['required'],
            'price' => ['required']
        ]);
    }
    public function itemAdd(){
        $component = ElectronicComponent::pluck('component_name','id')->toArray();
        return view('component.itemAdd',compact('component'));
    }

    public function itemEdit($id){

        $component = ElectronicComponent::pluck('component_name','id')->toArray();
        $item = ComponentDetails::find($id);
        return view('component.itemEdit',compact('component','item'));
    }

    public function itemStore(Request $request){
        $data = $request->all();
        $this->validator($data)->validate();
        ComponentDetails::create([
            'component_id' => $data['component'],
            'details' => $data['details'],
            'addition_price' => $data['price'],
            'status ' => 1
        ]);

        return redirect()->route('component.item');
    }

    public function update(Request $request){
        $data = $request->all();
        $this->validator($data)->validate();
        $itemId = $data['item_id'];
        $item = ComponentDetails::find($itemId);
        $item->component_id = $data['component'];
        $item->details = $data['details'];
        $item->addition_price = $data['price'];
        $item->save();
        return redirect()->route('component.item');
    }
}
