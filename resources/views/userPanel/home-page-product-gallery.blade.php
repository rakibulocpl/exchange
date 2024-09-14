<div class="card mt-5" style="border: none">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="card" style="border: none">
                <div class="card-body">
                    <h4 class="text-primary">Most Popular Laptops (Used)</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row  p-2 ">
        @foreach ($products as $product)
            <div class="p-item  mt-2">
                <div class="card">
                    <div class="p-2">
                        <div class="card-img-actions">
                            <a href="{{route('user.viewProduct',[$product->id])}}" class="text-default mb-2" data-abc="true">
                                <img data-src="{{asset($product->thumbnail)}}" src="{{asset('img/default-site-img.png')}}"  loading="lazy"   onerror="this.src=`{{asset('img/default-site-img.png')}}`"
                                     class="card-img img-fluid lazyload" width="96"  height="350" alt="product Image" >
                            </a>
                        </div>
                    </div>

                    <div class="card-body bg-light text-left p-2 product-details">
                        <div class="mb-2 product-title">
                            <h4 class="font-weight-semibold mb-2" >
                                <a href="{{route('user.viewProduct',[$product->id])}}" class="text-default mb-2" data-abc="true">{{$product->product_name}}</a>
                            </h4>
                        </div>
                        <div class="short-description text-left">
                            {!! $product->short_description !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <h4 class="mb-0 font-weight-semibold text-info">{{$product->price}}৳</h4>

                            <button type="button"  class="buy-now btn bg-primary bg-cart m-2" data-product="{{$product->id}}"><i class="fa fa-cart-plus mr-2"></i>
                                Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
</div>