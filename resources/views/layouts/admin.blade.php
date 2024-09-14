<!doctype html>
<html class="no-js" lang="en">
<head>
    @include('inc/admin-header')
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('inc/admin/navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <!-- partial:partials/_settings-panel.html -->
            @include('inc/admin/sidebar-right')
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('inc/admin/sidebar')
            <!-- partial -->
            <div class="content-wrapper">
            @include('inc/message')
                @yield('content')
                <!-- partial:partials/_footer.html -->
                @include('inc/admin/footer')
                <!-- partial -->
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- all js here -->
@include('inc/admin-footer')
@yield('footer-script')
</body>
</html>
