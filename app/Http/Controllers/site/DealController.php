<?php

namespace App\Http\Controllers\site;

use App\Models\DealChat;
use App\Models\DealList;
use App\Models\ExLaptopDetails;
use App\Models\UpgradeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DealController extends Controller
{
    protected $category_id;
    public function __construct()
    {
        $this->category_id = 2;

    }

    public function index(Request $request){
        $data['dealType'] = $request->segment(3);
        return view('deal.list',$data);
    }
    public function upgradeList(){
        return view('deal.upgradeList');
    }



    public function newDeal(Request $request){
        $validator              =        Validator::make($request->all(), [
            'model'=>'required',
            'brand'=>'required',
            'ram'=>'required',
            'ramstatus'=>'required',
            'processor'=>'required',
            'processorstatus'=>'required',
            'battery'=>'required',
            'storage'=>'required',
            'storagestatus'=>'required',
            'display'=>'required',
            'displaystatus'=>'required',
            'graphics'=>'required',
            'graphicsstatus'=>'required',
            'physicalstatus'=>'required',
            'laptoppower'=>'required',
            'frontimage'=>'required',
            'backimage'=>'required'
        ]);
        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
        try {

            DB::beginTransaction();
            $exLaptopDetails = new ExLaptopDetails();
            $exLaptopDetails->model =$request->get('model');
            $exLaptopDetails->brand_id =$request->get('brand');

            if ($request->hasFile('frontimage')){
                $_fontImage = $request->file('frontimage');
                $fileUpload = $this->uploadFile($_fontImage);
                if(is_array($fileUpload) && $fileUpload['code'] == -1){
                    return response()->json(['status'=>-1,'message'=>'invalid file format']);
                }else{
                    $exLaptopDetails->font_image = $fileUpload['path'];
                }
            }

            if ($request->hasFile('backimage')){
                $_backimage = $request->file('backimage');
                $fileUpload = $this->uploadFile($_backimage);
                if(is_array($fileUpload) && $fileUpload['code'] == -1){
                    return response()->json(['status'=>-1,'message'=>'invalid file format']);
                }else{
                    $exLaptopDetails->back_image = $fileUpload['path'];
                }
            }
            $exLaptopDetails->save();


            $dealistList = new DealList();
            $dealistList->ref_id = $exLaptopDetails->id;
            $dealistList->category_id = $this->category_id;
            $dealistList->status = 1;
            $dealistList->save();
            $trackingPrefix = $this->category_id;
            DB::statement("update  deal_list, deal_list as table2  SET deal_list.tracking_no=(
                            select concat('$trackingPrefix',
                                    LPAD( IFNULL(MAX(SUBSTR(table2.tracking_no,-8,8) )+1,1),8,'0')
                                          ) as tracking_no
                             from (select * from deal_list ) as table2
                             where table2.category_id ='$this->category_id' and table2.id!='$dealistList->id' and table2.tracking_no like '$trackingPrefix%'
                        )
                      where deal_list.id='$dealistList->id' and table2.id='$dealistList->id'");
            DB::commit();
            $tracking_no = self::getTrackingNoByDealId($dealistList->id);
            $appdata = ['tracking_no'=>$tracking_no];

            return response()->json(['status'=>1,"message"=>"submitted successfully",'appdata'=>$appdata]);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>-2,"message"=>$e->getMessage().$e->getFile().$e->getLine()]);

        }

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

    public function uploadFile($_file){
        $path = $this->checkFolder();

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

    public static function getTrackingNoByDealId($dealid)
    {
        return DealList::where('id', $dealid)->pluck('tracking_no');
    }


    public function getlist(Request $request,$dealType){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = DealList::leftjoin('product_categories as product','product.id','=','deal_list.category_id')
            ->leftjoin('users as customer','customer.id','=','deal_list.created_by')
            ->leftjoin('deal_status','deal_status.id','=','deal_list.status')
            ->whereNotIn('created_by',[0])
            ->where('deal_type',$dealType)
            ->orderBy('id','desc')
            ->get([
                'deal_list.*',
                'customer.phone as phone',
                'customer.name as customerName',
                'product.name as product',
                'deal_status.status_name',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
            ]);
        return Datatables::of($data)
            ->editColumn('created_at',function ($data){
                return Carbon::parse($data->created_at)->format('Y-M-d H:i A');
            })
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('deal.view',[$data->id])."'><i class='fa fa-folder-open'></i> </a>
                ";
            })
            ->rawColumns(['action','status'])
            ->setRowClass(function ($data) {
                return $data->deal_status == 1 ? 'unreadMessage' : ' ';
            })
            ->setRowAttr([
                'style' =>function ($data){
                    if ($data->status == 1) {
                        return 'background: -webkit-linear-gradient(left, rgba(255,251,199,1) 0%, rgba(255,251,199,1) 40%, rgba(255,251,199,1) 80%, rgba(255,255,255,1) 100%);font-weight:bold;';
                    }else{
                        return '';
                    }
                }
            ])
            ->make(true);
    }
    public function getlistUpgrade(Request $request){
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        DB::statement(DB::raw('set @rownum=0'));
        $data = UpgradeService::leftjoin('city_list as city','city.id','=','upgrade_service.city')
            ->leftjoin('product_categories as product','product.id','=','upgrade_service.category_id')
            ->leftjoin('deal_status','deal_status.id','=','upgrade_service.status')
            ->get([
                'upgrade_service.*',
                'product.name as product',
                'deal_status.status_name',
                'city.city_name',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
            ]);
        return Datatables::of($data)
            ->editColumn('created_at',function ($data){
                return Carbon::parse($data->created_at)->format('Y-M-d H:i A');
            })
            ->addColumn('action', function ($data) {
                return "<a style='cursor: pointer;padding:2px;' href='".route('deal.upgradeView',[$data->id])."'><i class='fa fa-folder-open'></i> </a>
                ";
            })
            ->rawColumns(['action','status'])
            ->setRowClass(function ($data) {
                return $data->deal_status == 1 ? 'unreadMessage' : ' ';
            })
            ->setRowAttr([
                'class' =>function ($data){
                    if (in_array($data->deal_status, [1])) {
                        return 'unreadMessage';
                    }else{
                        return '';
                    }
                }
            ])
            ->make(true);
    }
    public function dealList(){

        $dealList =DealList::get();
        return Datatables::of($dealList);
    }
    public function viewDeal($dealId){

        $dealChat = DealChat::where('deal_id',$dealId)->orderBy('id','desc')->get();

        $dealData = DealList::leftjoin('ex_laptop_details as exd','exd.id','=','deal_list.ref_id')
            ->leftjoin('users as customer','customer.id','=','deal_list.created_by')
            ->leftjoin('brands','brands.id','=','exd.brand_id')
            ->leftjoin('product_categories as product','product.id','=','deal_list.category_id')
            ->leftjoin('deal_status','deal_status.id','=','deal_list.status')
            ->where('deal_list.id',$dealId)
            ->first([
                'exd.*',
                'deal_list.tracking_no',
                'deal_list.created_by',
                'deal_list.deal_note',
                'deal_list.created_at as deal_date',
                'deal_list.estimated_price',
                'deal_list.deal_type',
                'customer.phone as customerPhone',
                'customer.name as customerName',
                'brands.name as brandName',
                'product.name as product',
                'deal_status.status_name',
                'deal_list.status'
            ]);
        $dealByThisUser =  DealList::leftjoin('ex_laptop_details as exd','exd.id','=','deal_list.ref_id')
            ->leftjoin('product_categories as product','product.id','=','deal_list.category_id')
            ->where('deal_list.created_by',$dealData->created_by)
            ->where('deal_list.id','!=',$dealId)
            ->get([
                'deal_list.tracking_no',
                'deal_list.deal_type',
                'deal_list.id',
            ]);
        $details = json_decode($dealData->details_json);
        return view('deal.view',compact('dealData','details','dealChat','dealByThisUser'));
    }

    public function upgradeView($dealId){
        $dealChat = DealChat::where('deal_id',$dealId)->where('deal_type',3)->orderBy('id','desc')->get();

        $dealData = UpgradeService::leftjoin('brands','brands.id','=','upgrade_service.brand_id')
            ->leftjoin('product_categories as product','product.id','=','upgrade_service.category_id')
            ->leftjoin('deal_status','deal_status.id','=','upgrade_service.status')
            ->leftjoin('city_list as city','city.id','=','upgrade_service.city')
            ->leftjoin('thana_list as thana','thana.id','=','upgrade_service.thana')
            ->where('upgrade_service.id',$dealId)
            ->first([
                'upgrade_service.*',
                'city.city_name as city',
                'thana.thana_name as thana',
                'brands.name as brandName',
                'product.name as product',
                'deal_status.status_name'
            ]);
        $details = json_decode($dealData->details_json);
        return view('deal.upgrade-view',compact('dealData','details','dealChat'));
    }

    public function updateNote(Request $request){
        DealList::where('id',$request->deal_id)->update([
           "deal_note"=>$request->deal_note
        ]);
        return redirect()->back();
    }
}
