<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" target="_blank" href="/"><img src="/images/logo.svg" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" target="_blank" href="/"><img src="/images/logo-mini.svg" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        @if(Session::get('branch_name'))
            {{Session::get('branch_name')}}
        @endif
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <a class="nav-link  dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    {{\Illuminate\Support\Facades\Auth::user()->name}}
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-left bg-inverse-primary" aria-labelledby="actionDropdown">
                    <a class="dropdown-item" href="{{route('user.profile')}}">
                        <img src="{{!empty(\Illuminate\Support\Facades\Auth::user()->photo_url)?url(\Illuminate\Support\Facades\Auth::user()->photo_url):url('images/blank.png')}}"  style="border-radius: 50%;height: 80px;width: 80px;" alt="User Image"><br>

                    </a>
                    <div class="text-center">
                        <a href="{{ route('logout') }}"  class="btn btn-default btn-flat text-dark" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"><strong><i class="fa fa-sign-out"></i> Sign out</strong></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>

                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
