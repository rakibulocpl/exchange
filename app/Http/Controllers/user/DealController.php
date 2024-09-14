<?php

namespace App\Http\Controllers\user;

use App\Events\SendDealSubmissionNotification;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\CityList;
use App\Models\ComponentDetails;
use App\Models\DealList;
use App\Models\ElectronicComponent;
use App\Models\ExLaptopDetails;
use App\Models\ProductCategory;
use App\Models\UpgradeService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
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

    public function NewDealForm(Request $request, $catId = 0)
    {

        $data['selectedData'] = $request->all();
        if ($catId == 0) {
            $data['category'] = ProductCategory::where('parent_id', 1)->pluck('name', 'id')->toArray();
        } else {
            $data['category'] = ProductCategory::where('id', $catId)->first();
        }

        $data['brand'] = Brand::where('status', 1)->pluck('name', 'id')->toArray();
        $components = ElectronicComponent::where('electronics_components.status', 1)
            ->leftjoin('component_details as cd', 'electronics_components.id', 'cd.component_id')
            ->get(['cd.*', 'electronics_components.component_name']);

        $allComponents = [];
        $data['dealType'] = $request->segment(1);
        $data['catId'] = $catId;

        if (count($components) > 0) {
            foreach ($components as $component) {
                $allComponents[$component->component_name][$component->id . '@' . $component->details] = $component->details;
            }
        }
        $data['allComponents'] = $allComponents;
        $data['city'] = CityList::where('status', 1)->pluck('city_name as display', 'id')->toArray();
        return view('userPanel.newDealForm', $data);
    }

    public function upgradeForm(Request $request, $catId = 0)
    {
        $data['selectedData'] = $request->all();
        if ($catId == 0) {
            $data['category'] = ProductCategory::where('parent_id', 1)->pluck('name', 'id')->toArray();
        } else {
            $data['category'] = ProductCategory::where('id', $catId)->first();
        }
        $data['brand'] = Brand::where('status', 1)->pluck('name', 'id')->toArray();
        $data['dealType'] = $request->segment(1);
        $data['catId'] = $catId;

        $data['city'] = CityList::where('status', 1)->pluck('city_name as display', 'id')->toArray();
        return view('userPanel.upgradeForm', $data);
    }

    public function newDeal(Request $request)
    {
        $catId = $request->get('product');
        $rules = [
            'brand' => 'required',
            'ram' => 'required',
            'ramstatus' => 'required',
            'processor' => 'required',
            'processorstatus' => 'required',
            'deal_type' => 'required',
            'storage' => 'required',
            'storagestatus' => 'required',
            'display' => 'required',
            'displaystatus' => 'required',
            'graphics' => 'required',
            'graphicsstatus' => 'required',
            'laptoppower' => 'required',
            'back_image_path' => 'required',
            'front_image_path' => 'required'
        ];
        if ($catId == 2) {
            $rules['battery'] = 'required';
            $rules['physicalstatus'] = 'required';
        }
//        dd($request->all());
        $components = $request->only(['ram', 'processor', 'storage', 'display', 'graphics','battery','monitor_size']);
        $componentsStatus = $request->only(['ramstatus', 'processorstatus', 'graphicsstatus', 'storagestatus', 'displaystatus']);
        list($priceList, $totalPrice) = $this->calculatePrice($components, $componentsStatus);


        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        try {
            DB::beginTransaction();
            $exLaptopDetails = new ExLaptopDetails();
            $exLaptopDetails->model = $request->get('model');
            $exLaptopDetails->brand_id = $request->get('brand');
            $exLaptopDetails->details_json = json_encode($request->all());
            $exLaptopDetails->price_list_calculated = json_encode($priceList);
            $exLaptopDetails->total_price_calculated = $totalPrice;

            $exLaptopDetails->font_image = ltrim($request->get('front_image_path'), '/');

            $exLaptopDetails->back_image = ltrim($request->get('back_image_path'), '/');
            $exLaptopDetails->save();

            $dealistList = new DealList();
            $dealistList->ref_id = $exLaptopDetails->id;
            $dealistList->category_id = $catId;
            $dealistList->deal_type = $request->get('deal_type');
            $dealistList->status = 1;
            $dealistList->save();

            $user = User::where('id', Auth::user()->id)->first();
            $user->name = $request->get('username');
            $user->email = $request->get('email');
            $user->city = $request->get('city');
            $user->save();
            if ($dealistList->deal_type == 'exchange') {
                $trackingPrefix = 1;
            } else {
                $trackingPrefix = 2;
            }

            DB::statement("update  deal_list, deal_list as table2  SET deal_list.tracking_no=(
                            select concat('$trackingPrefix',
                                    LPAD( IFNULL(MAX(SUBSTR(table2.tracking_no,-5,5) )+1,1),5,'0')
                                          ) as tracking_no
                             from (select * from deal_list ) as table2
                             where  table2.id!='$dealistList->id' and table2.tracking_no like '$trackingPrefix%'
                        )
                      where deal_list.id='$dealistList->id' and table2.id='$dealistList->id'");

            DB::commit();

            $tracking_no = self::getTrackingNoByDealId($dealistList->id);
            $data = (object)['message' => "Submitted a new deal Deal Id : $tracking_no", 'email' => 'info@systemeye.net'];
//            event(new SendDealSubmissionNotification($data));

            return redirect()->to('deal/confirmation');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', "Please Contact with Support team");
            return redirect()->to('/');

        }

    }

    public function storeUpgrade(Request $request)
    {
        try {

            DB::beginTransaction();
            $upgradeDetails = new UpgradeService();
            $upgradeDetails->category_id = $request->get('product');
            $upgradeDetails->model = $request->get('model');
            $upgradeDetails->brand_id = $request->get('brand');
            $upgradeDetails->upgrade_note = $request->get('upgrade_note');
            $upgradeDetails->user_name = $request->get('username');
            $upgradeDetails->phone = $request->get('mobileno');
            $upgradeDetails->email = $request->get('email');
            $upgradeDetails->address_line = $request->get('address_line');
            $upgradeDetails->city = $request->get('city');
            $upgradeDetails->thana = $request->get('thana');
            $upgradeDetails->service_from = $request->get('service_from');
            $upgradeDetails->save();
            $trackingPrefix = 4;
            DB::statement("update  upgrade_service, upgrade_service as table2  SET upgrade_service.tracking_no=(
                            select concat('$trackingPrefix',
                                    LPAD( IFNULL(MAX(SUBSTR(table2.tracking_no,-5,5) )+1,1),5,'0')
                                          ) as tracking_no
                             from (select * from upgrade_service ) as table2
                              where table2.id!='$upgradeDetails->id' and table2.tracking_no like '$trackingPrefix%'
                        )
                      where upgrade_service.id='$upgradeDetails->id' and table2.id='$upgradeDetails->id'");
            DB::commit();

            return redirect()->to('update/confirmation');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => -2, "message" => $e->getMessage() . $e->getFile() . $e->getLine()]);

        }

    }

    public function confirmation()
    {
        return view('userPanel.confirmation');
    }

    public function confirmationUpdate()
    {
        return view('userPanel.update-confirmation');
    }

    public function viewDeal($trackingno)
    {
        $dealData = DealList::leftjoin('ex_laptop_details as exd', 'exd.id', '=', 'deal_list.ref_id')
            ->leftjoin('users as customer', 'customer.id', '=', 'deal_list.created_by')
            ->leftjoin('brands', 'brands.id', '=', 'exd.brand_id')
            ->leftjoin('product_categories as product', 'product.id', '=', 'deal_list.category_id')
            ->leftjoin('deal_status', 'deal_status.id', '=', 'deal_list.status')
            ->where('deal_list.tracking_no', $trackingno)
            ->first([
                'exd.*',
                'deal_list.tracking_no',
                'deal_list.created_at as deal_date',
                'deal_list.estimated_price',
                'customer.phone as customerPhone',
                'customer.name as customerName',
                'brands.name as brandName',
                'product.name as product',
                'deal_status.status_name'
            ]);
        $details = json_decode($dealData->details_json);
        return view('userPanel.view', compact('dealData', 'details'));
    }


    public function checkFolder()
    {
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

    public function uploadFile($_file)
    {
        $path = $this->checkFolder();
        $prefix = 'laptop_';
        $docBaseUrl = url('uploads');
        $i = strripos($_file->getClientOriginalName(), '.');
        $ext = strtolower(substr($_file->getClientOriginalName(), $i + 1));
        $original_file = uniqid($prefix, true) . "." . $ext;
        $file_type = $_file->getClientMimeType();
        if ($file_type == 'application/pdf') {
            return array('code' => -1, "error" => "invalid file type");
        }
        $authoFileUrl = $original_file;
        $_file->move($path, $authoFileUrl);
        return array('code' => 1, "path" => $path . '/' . $authoFileUrl);
    }

    public function getDealDetails($trackNo)
    {
        $tracking_no = $trackNo;
        $dealData = DealList::leftjoin('ex_laptop_details as exd', 'exd.id', '=', 'deal_list.ref_id')
            ->leftjoin('users as customer', 'customer.id', '=', 'deal_list.created_by')
            ->leftjoin('brands', 'brands.id', '=', 'exd.brand_id')
            ->leftjoin('product_categories as product', 'product.id', '=', 'deal_list.category_id')
            ->leftjoin('deal_status', 'deal_status.id', '=', 'deal_list.status')
            ->where('deal_list.tracking_no', $tracking_no)
            ->first([
                'exd.*',
                'deal_list.tracking_no',
                'deal_list.created_at as deal_date',
                'customer.phone as customerPhone',
                'customer.name as customerName',
                'brands.name as brandName',
                'product.name as product',
                'deal_status.status_name'
            ]);
        $details = json_decode($dealData->details_json);
        $defaultImage = 'uploads/default.jpg';
        $dealInfo = [
            'track_no' => $dealData->tracking_no,
            'deal_date' => date('d-M-Y', strtotime($dealData->deal_date)),
            'customer_phone' => $dealData->customerPhone,
            'customer_name' => $dealData->customerName,
            'brand_name' => $dealData->brandName,
            'model' => $dealData->model,
            'status_name' => $dealData->status_name,
            'product' => $dealData->product,
            'power' => $details->laptoppower,
            'ram' => ($details->ram ? explode('@', $details->ram)[1] : '') . ' / ' . $details->ramstatus,
            'processor' => ($details->processor ? explode('@', $details->processor)[1] : '') . ' / ' . $details->processorstatus,
            'display' => ($details->display ? explode('@', $details->display)[1] : '') . ' / ' . $details->displaystatus,
            'storage' => ($details->storage ? explode('@', $details->storage)[1] : '') . ' / ' . $details->storagestatus,
            'graphics' => ($details->graphics ? explode('@', $details->graphics)[1] : '') . ' / ' . $details->graphicsstatus,
            'physicalCondition' => $details->physicalstatus,
            'moreCondition' => '',
            'font_image' => !empty($dealData->font_image) ? url($dealData->font_image) : url($defaultImage),
            'back_image' => !empty($dealData->back_image) ? url($dealData->back_image) : url($defaultImage)

        ];
        return response()->json($dealInfo);
    }

    public static function getTrackingNoByDealId($dealid)
    {
        return DealList::where('id', $dealid)->value('tracking_no');
    }

    public function myDeal()
    {
        $dealList = DealList::where('created_by', Auth::user()->id)
            ->leftjoin('product_categories as product', 'product.id', '=', 'deal_list.category_id')
            ->leftjoin('deal_status', 'deal_status.id', '=', 'deal_list.status')
            ->get([
                'deal_list.tracking_no',
                'deal_list.created_at as deal_date',
                'product.name as product',
                'deal_status.status_name'
            ]);
        return view('userPanel.my-deal', compact('dealList'));
    }

    public function dealList()
    {
        $dealList = DealList::where('created_by', Auth::user()->id)
            ->leftjoin('product_categories as product', 'product.id', '=', 'deal_list.category_id')
            ->leftjoin('deal_status', 'deal_status.id', '=', 'deal_list.status')
            ->get([
                'deal_list.tracking_no',
                'deal_list.created_at as deal_date',
                'product.name as product',
                'deal_status.status_name'
            ]);
        return response()->json($dealList);
    }

    private function calculatePrice($components, $componentsStatus)
    {

        $workingComponentIds = [];
        $all = [];
        foreach ($components as $key => $value) {
            /*$key = component Name*/
            if (!empty($value)){
                $status = '';
                list($componentId, $componentDetails) = explode('@', $value);
                $noStatusComponents = ['battery','monitor_size']; /*have no status*/
                if (!in_array($key,$noStatusComponents)){
                    $statusName = $key . 'status';
                    $status = $componentsStatus[$statusName];
                    if ($status == 'working') {
                        $workingComponentIds[] = $componentId;
                    }
                }else{
                    $workingComponentIds[] = $componentId;
                }


                $all [$componentId] = [
                    'component' => $key,
                    'details' => $componentDetails,
                    'status' => $status
                ];

            }


        }

        $priceList = ComponentDetails::whereIn('id', $workingComponentIds)->get(['id', 'addition_price']);

        $total = $priceList->sum('addition_price'); // Sum the prices directly
        foreach ($priceList as $price) {
            $all[$price->id]['price'] = $price->addition_price;
        }

        return [$all, $total];

    }
}

