<?php

namespace App\Http\Controllers;

use App\Models\DealList;
use App\Models\ExLaptopDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DealController extends Controller
{
    protected $category_id;
    public function __construct()
    {
        $this->category_id = 2;

    }

    public function newDeal(Request $request){
        dd(1);
        dd($request->all());
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
        dd($request->all());
        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }

        try {

            DB::beginTransaction();
            $exLaptopDetails = new ExLaptopDetails();
            $exLaptopDetails->model =$request->get('model');
            $exLaptopDetails->brand_id =$request->get('brand');
            $exLaptopDetails->details_json =json_encode($request->all());

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

    public function getDealDetails($trackNo){
        $tracking_no = $trackNo;
        $dealData = DealList::leftjoin('ex_laptop_details as exd','exd.id','=','deal_list.ref_id')
            ->leftjoin('users as customer','customer.id','=','deal_list.created_by')
            ->leftjoin('brands','brands.id','=','exd.brand_id')
            ->leftjoin('product_categories as product','product.id','=','deal_list.category_id')
            ->leftjoin('deal_status','deal_status.id','=','deal_list.status')
            ->where('deal_list.tracking_no',$tracking_no)
            ->first([
                'exd.*',
                'deal_list.tracking_no',
                'deal_list.deal_type',
                'deal_list.created_at as deal_date',
                'customer.phone as customerPhone',
                'customer.name as customerName',
                'brands.name as brandName',
                'product.name as product',
                'deal_status.status_name'
            ]);
        $details = json_decode($dealData->details_json);
        $defaultImage ='uploads/default.jpg';
        $dealInfo = [
            'track_no' => $dealData->tracking_no,
            'deal_date' => date('d-M-Y',strtotime($dealData->deal_date)),
            'customer_phone' => $dealData->customerPhone,
            'customer_name' => $dealData->customerName,
            'brand_name' => $dealData->brandName,
            'model' => $dealData->model,
            'status_name' => $dealData->status_name,
            'product' => $dealData->product,
            'power' => $details->laptoppower,
            'ram' => ($details->ram?explode('@',$details->ram)[1]:'').' / '.$details->ramstatus,
            'processor' => ($details->processor?explode('@',$details->processor)[1]:'').' / '.$details->processorstatus,
            'display' => ($details->display?explode('@',$details->display)[1]:'').' / '.$details->displaystatus,
            'storage' => ($details->storage?explode('@',$details->storage)[1]:'').' / '.$details->storagestatus,
            'graphics' => ($details->graphics?explode('@',$details->graphics)[1]:'').' / '.$details->graphicsstatus,
            'physicalCondition' => $details->physicalstatus,
            'moreCondition' => '',
            'font_image' => !empty($dealData->font_image)?url($dealData->font_image):url($defaultImage),
            'back_image'=> !empty($dealData->back_image)?url($dealData->back_image):url($defaultImage)

        ];
        return response()->json($dealInfo);
    }

    public static function getTrackingNoByDealId($dealid)
    {
        return DealList::where('id', $dealid)->pluck('tracking_no');
    }

    public function list(){
        return view('deal.list');
    }

    public function dealList(){
        $dealList =DealList::where('created_by',Auth::user()->id)
            ->leftjoin('product_categories as product','product.id','=','deal_list.category_id')
            ->leftjoin('deal_status','deal_status.id','=','deal_list.status')
        ->get([
            'deal_list.tracking_no',
            'deal_list.created_at as deal_date',
            'product.name as product',
            'deal_status.status_name'
        ]);
        return response()->json($dealList);
    }
}
