<?php

namespace App\Http\Controllers\site;


use App\Exports\DealExport;
use App\Http\Controllers\site\CommonFunction;
use App\Models\DealChat;
use App\Models\DealList;
use App\Models\ExLaptopDetails;
use App\Models\UpgradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ManageDealController extends Controller
{
    public function __construct()
    {

    }


    public function sentEstimatedPrice(Request $request){
        try {
            DB::beginTransaction();;
            $dealId = $request->get('deal_id');
            $estimatedValue = $request->get('estimated_price');
            $customerPhone = $request->get('customer_phone');
            $tracking_no = self::getTrackingNoByDealId($dealId);
            DealList::where('id',$dealId)->update(['status'=>2,'estimated_price'=>$estimatedValue]);
            $sms_body = "স্যার, আপনার ডিভাইসের সর্বোচ্চ দাম হবে $estimatedValue টাকা।"."\n"."Deal ID: $tracking_no"."\n".
                "Thank You!"."\n"."-SystemEye Exchange,"."\n"."Helpline: 01757555999";
            



            // CommonFunction::send_sms_with_mask($customerPhone,$sms_body);
            CommonFunction::send_sms($customerPhone,$sms_body);
            DB::commit();;
            Session::flash('success', "Successfully Sent !! ");
            return redirect()->back();
        }catch (\Exception $e){
            Session::flash('error', "Something Wrong !! ");
            return redirect()->back();
        }

    }
    public function sendUpgradeCost(Request $request){
        try {
            DB::beginTransaction();;
            $dealId = $request->get('deal_id');
            $estimatedValue = $request->get('estimated_price');
            $customerPhone = $request->get('customer_phone');
            $tracking_no = self::getTrackingNoByDealId($dealId);
            UpgradeService::where('id',$dealId)->update(['status'=>2,'estimated_cost'=>$estimatedValue]);
            $sms_body = "স্যার, আপনার ডিভাইসের সর্বোচ্চ খরচ হবে $estimatedValue টাকা।"."\n"."Deal ID: $tracking_no"."\n".
                "Thank You!"."\n"."-Exchange,"."\n"."Helpline: 01757555999";

            // CommonFunction::send_sms_with_mask($customerPhone,$sms_body);
            CommonFunction::send_sms($customerPhone,$sms_body);
            DB::commit();;
            Session::flash('success', "Successfully Sent !! ");
            return redirect()->back();
        }catch (\Exception $e){
            Session::flash('error', "Something Wrong !! ");
            return redirect()->back();
        }

    }

    public function downloadDeal(){
        return view('deal.download-deal');
    }

    public function download(Request $request){
        return Excel::download(new DealExport($request->start_date,$request->end_date), 'deal'. '_' . date('Y-m') . '.xlsx');
    }

    public function sendSms(Request $request){
        try {

            $dealId = $request->get('deal_id');
            $dealType= $request->get('deal_type');
            $smsText = $request->get('general_sms');
            $customerPhone = $request->get('customer_phone');
            $tracking_no = self::getTrackingNoByDealId($dealId);
            DB::beginTransaction();
            DealChat::create([
                'deal_type' => $dealType,
                'deal_id' => $dealId,
                'message' => $smsText
            ]);
            $smsText = $smsText."\n\n"."-SystemEye Exchange,"."\n"."Helpline: 01757555999";
            CommonFunction::send_sms($customerPhone,$smsText);
            DB::commit();
            Session::flash('success', "Successfully Sent !! ");
            return redirect()->back();
        }catch (\Exception $e){
            dd($e->getLine().$e->getMessage());
            Session::flash('error', "Something Wrong !! ");
            return redirect()->back();
        }

    }

    public static function getTrackingNoByDealId($dealid)
    {
        $trackingNo = DealList::where('id', $dealid)->value('tracking_no');

        return $trackingNo;
    }
    public static function getUpgradeTrackingNo($dealid)
    {
        return UpgradeService::where('id', $dealid)->value('tracking_no');
    }

}
