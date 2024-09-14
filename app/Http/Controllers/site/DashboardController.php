<?php

namespace App\Http\Controllers\site;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PragmaRX\Tracker\Tracker;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $sessions = Tracker::sessions(60 * 24);
        $data = [];
//        $sales = Sales::where('date',date('Y-m-d'));
//        if (isAdmin() ==false){
//            $sales =  $sales->where('branch_id',CommonFunction::getBranchCode());
//        }
//           $sales = $sales->sum('grand_total');
//        $cost = Sales::leftjoin('sale_items as si','si.sale_id','sale.id');
//        if (isAdmin() == false){
//            $cost =  $cost->where('branch_id',CommonFunction::getBranchCode());
//        }
//        $cost = $cost->where('date',date('Y-m-d'))->sum('subtotal_cost');
//        $profit = ($sales-$cost);
//        $purchase = Purchase::where('date',date('Y-m-d'));
//              if (isAdmin() == false){
//                  $purchase =  $purchase->where('branch_id',CommonFunction::getBranchCode());
//              }
//            $purchase = $purchase->sum('grand_total');
//        $collection = Payment::where('date',date('Y-m-d'));
//         if (isAdmin() == false){
//             $collection =  $collection->where('branch_id',CommonFunction::getBranchCode());
//         }
//        $collection = $collection->where('type','received')->sum('amount');
//        $stock = Stock::select(DB::raw('sum(quantity) as total_quantity,sum(p.cost_price*quantity) as total_cost'))
//            ->leftjoin('products as p','p.code','stock.product_code');
//        if (isAdmin() == false){
//           $stock =  $stock->where('stock.branch_id',CommonFunction::getBranchCode());
//        }
//        $stock = $stock->where('quantity','>',0)
//            ->first();
//    $data =['sales'=>$sales,'profit'=>$profit,'purchase'=>$purchase,'collection'=>$collection,'stock'=>$stock];

        return view('admin.dashboard',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
