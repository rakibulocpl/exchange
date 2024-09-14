<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\ImageGallery;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
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
        $products = Product::where('is_published',1)->paginate(15);
        return view('userPanel.shop',compact('products'));
    }
    public function shopByCategory($slug)
    {
        $category = Category::where('slug',$slug)->first();
        $products = Product::where('category_id',$category->id)->where('is_published',1)->paginate(15);
        return view('userPanel.shop',compact('products','category'));
    }

    public function viewProduct(Product $product){
        $images = ImageGallery::where('product_id',$product->id)->get();
        return view('userPanel.product-view',compact('product','images'));

    }
}
