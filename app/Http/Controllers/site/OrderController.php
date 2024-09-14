<?php

namespace App\Http\Controllers\site;

use App\Models\DealChat;
use App\Models\DealList;
use App\Models\ExLaptopDetails;
use App\Models\Order;
use App\Models\Product;
use App\Models\UpgradeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index(Request $request){
        $data['dealType'] = $request->segment(3);
        return view('order.list',$data);
    }
    public static function getTrackingNoByDealId($dealid)
    {
        return Order::where('id', $dealid)->pluck('tracking_no');
    }
    
    public function getlist(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = Order::leftjoin('city_list as city','city.id','=','orders.customer_area')
            ->leftjoin('deal_status','deal_status.id','=','orders.status')
            ->get([
                'orders.*',
                'deal_status.status_name',
                'city.city_name',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
            ]);
        return Datatables::of($data)
            ->editColumn('created_at',function ($data){
                return Carbon::parse($data->created_at)->format('Y-M-d H:i A');
            })
            ->addColumn('action', function ($data) {
                    return "<a style='cursor: pointer;padding:2px;' href='".route('order.view',[$data->id])."'><i class='fa fa-folder-open'></i> </a>
                ";
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
    public function dealList(){

        $dealList =DealList::get();
        return Datatables::of($dealList);
    }
   

    public function view($dealId){
        $dealChat = DealChat::where('deal_id',$dealId)->where('deal_type',5)->orderBy('id','desc')->get();

        $dealData = Order::leftjoin('deal_status','deal_status.id','=','orders.status')
            ->leftjoin('city_list as city','city.id','=','orders.customer_area')
            ->where('orders.id',$dealId)
            ->first([
                'orders.*',
                'city.city_name as city',
                'deal_status.status_name'
            ]);
        $products = Product::whereIn('id',explode(',',$dealData->product_ids))->get();
        return view('order.view',compact('dealData','dealChat','products'));
    }
}
