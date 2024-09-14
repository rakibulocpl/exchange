<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="  nav-link" href="{{route('dashboard.index')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if(isAdmin())
        <li class="nav-item">
            <a class="nav-link" href="{{route('user.list')}}">
                <i class="icon-folder menu-icon"></i>
                <span class="menu-title">USERS</span>
            </a>
        </li>
        @endif


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#deal" aria-expanded="false" aria-controls="ui-basic">
                <i class=" icon-paper-plane menu-icon"></i>
                <span class="menu-title">Deal List</span>
            </a>
            <div class="collapse" id="deal">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('deal.list')}}"> Exchange List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('deal.sellList')}}"> Sell List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('order.orderList')}}"> Order List </a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('deal.upgradeList')}}"> Upgrade List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('deal.downloadDeal')}}"> Download Deal</a></li>
                </ul>
            </div>
        </li>

        @if(isAdmin())
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#component" aria-expanded="false" aria-controls="ui-basic">
                <i class=" icon-paper-plane menu-icon"></i>
                <span class="menu-title">Component</span>
            </a>
            <div class="collapse" id="component">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{route('component.list')}}">Component list</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('component.item')}}">Component Item</a></li>
                </ul>
            </div>
        </li>
        @endif

        @if(isAdmin())
            <li class="nav-item">
                <a class="nav-link" href="{{route('brand.list')}}">
                    <i class="icon-folder menu-icon"></i>
                    <span class="menu-title">Brands</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{route('product.list')}}">
                <i class="icon-folder menu-icon"></i>
                <span class="menu-title">Products</span>
            </a>
        </li>
        @if(isAdmin())
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="ui-basic">
                    <i class=" icon-paper-plane menu-icon"></i>
                    <span class="menu-title">Settings</span>
                </a>
                <div class="collapse" id="settings">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('branch.list')}}">Branch</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('slider.list')}}">Slider</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('page.list')}}">Pages</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('categories.index')}}">Categories</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('pressMedia.list')}}">Press and Media</a></li>
                    </ul>
                </div>
            </li>
        @endif



    </ul>
</nav>
