<!-- Footer -->
<style>
    footer p{
        margin-bottom: .5em !important;
    }
</style>
<hr style="border-top:1px solid #8d9690 !important;">
<footer class="text-center text-lg-start bg-light text-muted pt-1">
    <section class="">
        <div class="container text-left text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-2">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/site/img/logo.png" alt="" class="logo__img">
                    </a>
                    <br>
                    <br>

                    <h6 class="text-uppercase fw-bold mb-2">Contact us</h6>
                    <p class=" fw-bold " style="font-size: 14px">
                        <i style="color: #00AEEF;font-size: 18px" style="color: #00AEEF;font-size: 18px" class="fas fa-map-marker-alt"></i> Navana Osman @ Link (Level-5), 214/D, Gulshan-Tejgaon Link Road, Tejgaon I/A, Dhaka-1208
                    </p>
                    <p><i style="color: #00AEEF;font-size: 18px" class="fas fa-phone "></i> +88 01757555999, 09678800514</p>
                    <p>
                        <i style="color: #00AEEF;font-size: 18px" class="fas fa-envelope "></i>
                        info@exchangekori.com
                    </p>
                    <p class=" fw-bold " style="font-size: 14px">
                        <i style="color: #00AEEF;font-size: 18px" style="color: #00AEEF;font-size: 18px" class="fas fa-map-marker-alt"></i>
                        Mirpur Branch
                        GA Foundation Building, 3rd Floor, House-5, Road-1, Main Road, Pallabi Rd, Mirpur-11, Dhaka 1216
                    </p>
                    <p><i style="color: #00AEEF;font-size: 18px" class="fas fa-phone "></i>+8801765668800, 09678800514</p>

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        Services
                    </h6>
                    <p>

                        <a href="{{route('user.sellForm')}}" class="text-reset">Sell</a>
                    </p>
                    <p>
                        <a href="{{route('user.exchangeForm')}}" class="text-reset">Exchange</a>
                    </p>
                    <p>
                        <a href="{{route('user.shop')}}" class="text-reset">Buy</a>
                    </p>
                    <p>
                        <a href="{{route('user.upgradeForm')}}" class="text-reset">Upgrade</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-2">
                        Useful links
                    </h6>
                    <p>
                        <a href="{{route('aboutUs')}}" class="text-reset">About Us</a>
                    </p>
                    <p>
                        <a href="{{route('team')}}" class="text-reset">Team </a>
                    </p>
                    <p>
                        <a href="{{route('career')}}" class="text-reset">Career </a>
                    </p>
                    <p>
                        <a href="{{route('pressAndMedia')}}" class="text-reset">Press & Media</a>
                    </p>
                    <p>
                        <a href="{{route('clients')}}" class="text-reset">Clients </a>
                    </p>

                    <p>
                        <a href="{{route('exchangePolicy')}}" class="text-reset">Exchange & Sell Policy</a>
                    </p>
                    <p>
                        <a href="{{route('termsCondition')}}" class="text-reset">Terms & Conditions</a>
                    </p>
                    <p>
                        <a href="{{route('privacy')}}" class="text-reset">Privacy Policy</a>
                    </p>
                    <p>
                        <a href="{{route('pagePublicView',['returnPolity'])}}" class="text-reset">Return Policy</a>
                    </p>
                    <p>
                        <a href="{{route('pagePublicView',['refundPolity'])}}" class="text-reset">Refund Policy</a>
                    </p>
                    <p>
                        <a href="{{route('pagePublicView',['afterSale'])}}" class="text-reset">After-Sale Support</a>
                    </p>
                    <p>
                        <a href="{{route('pagePublicView',['replacement'])}}" class="text-reset">Replacement Warranty</a>
                    </p>
                    <p>
                        <a href="{{route('pagePublicView',['shippingDelivery'])}}" class="text-reset">Shipping & Delivery</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Social Media</h6>
                    <ul class="p-0" style="display: inline-flex;list-style: none;font-size: 26px;">
                        <li class="p-3">
                            <a href="https://www.facebook.com/exchangekori" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                        </li>
                        <li class="p-3">
                            <a href="https://www.instagram.com/exchange_kori" target="_blank">
                            <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © {{date('Y')}} Copyright:
        <a class="text-reset fw-bold" target="_blank" href="#">Exchangekori Ltd</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->