<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Models\CityList;
use App\Models\DealList;
use App\Models\ExLaptopDetails;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $storeAddresses = config('stores.offices');
        $city  = CityList::where('status',1)->pluck('city_name','id')->toArray();
        $cart = session('cart', []);
        return view('userPanel.cart-view', compact('cart','city','storeAddresses'));
    }

    public function addToCart(Request $request)
    {
        $product_id = $request->get('product_id');
        $product = Product::find($product_id);
        if ($product) {
            $cart = session('cart', []);
            $newProduct = ['id' => $product->id, 'name' => $product->product_name, 'price' => $product->price,'thumbnail'=>$product->thumbnail];
            $cart[] = $newProduct;
            session(['cart' => $cart]);
            return response()->json(['responseCode' => 1]);
        } else {
            return response()->json(['responseCode' => -1, 'message', 'Product not available .']);
        }
    }

    public function checkout(Request $request){

        try {

            DB::beginTransaction();
            $order = new Order();
            $order->product_ids = implode(',',$request->get('product_id'));
            $order->customer_name =$request->get('username');
            $order->mobile_no =$request->get('mobileno');
            $order->email =$request->get('email');
            $order->customer_area =$request->get('city');
            $order->address =$request->get('address_line');
            $order->service_from =$request->get('service_from');
            $order->selected_office =$request->get('selected_office');
            $order->status = 1;
            $order->save();
            $trackingPrefix = 5;
            DB::statement("update  orders, orders as table2  SET orders.tracking_no=(
                            select concat('$trackingPrefix',
                                    LPAD( IFNULL(MAX(SUBSTR(table2.tracking_no,-5,5) )+1,1),5,'0')
                                          ) as tracking_no
                             from (select * from orders ) as table2
                              where table2.id!='$order->id' and table2.tracking_no like '$trackingPrefix%'
                        )
                      where orders.id='$order->id' and table2.id='$order->id'");
            DB::commit();
            Session::forget('cart');
            Session::flash('success', "ধন্যবাদ!আপনার  টি সাবমিট করা হয়েছে।");
            return redirect()->to('update/confirmation');
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>-2,"message"=>$e->getMessage().$e->getFile().$e->getLine()]);

        }
    }


    public function selectForExchange(Request $request)
    {

        $dealId = $request->input('deal_id');
        $productId = $request->input('product_id');

        $deal = DealList::where('tracking_no', $dealId)->first();
        if (!$deal) {
            return response()->json([
                'success' => false,
                'message' => 'Deal not found.'
            ], 404);
        }

        $exchangeLaptop = ExLaptopDetails::find($deal->ref_id);

        if (!$exchangeLaptop) {
            return response()->json([
                'success' => false,
                'message' => 'Exchange laptop details not found.'
            ], 404);
        }

        $exchangeLaptop->selected_product_for_exchange = $productId;
        $exchangeLaptop->save();

        Session::forget('dealId');

        // Return a successful response
        return response()->json([
            'success' => true,
            'message' => 'Selected product for exchange has been updated successfully.'
        ], 200);
    }




    public function removeItem($productId){
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);
        return redirect()->route('user.viewCart');
    }
}
