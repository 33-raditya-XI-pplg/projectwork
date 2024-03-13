<nav class="navbar" id="panel-navbar">
    <div class="navbar-left">
        {{-- <button class="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars" ></i></button> --}}
        <div style="{{ count(Request::segments()) > 2 ? "--bs-breadcrumb-divider: '>'" : "--bs-breadcrumb-divider: ''" }};">
            <ol class="breadcrumb">
              <li class="breadcrumb-item text-primary text-capitalize h4">{{ Request::segment(2) }}</li>
              <li class="breadcrumb-item text-capitalize h4">{{ Str::replace('-', ' ', Request::segment(3)); }}</li>
            </ol>
        </div>
    </div>
        
    <div class="navbar-right">
        <div class="nav-dropdown">
            <button class="nav-dropdown-btn">
                <div class="nav-dropdown-img">
                    <img src="{{ asset('assets/img/icon.png') }}" alt="0">
                </div>
                <div class="users-login ml-10">Dedi hariyanto <h6 id="roles">admin</h6></div>
                {{-- <span class="nav-dropdown-title">{{ auth()->user()->name }}</span> --}}
            </button>
            <div class="nav-dropdown-content">
                <ul class="nav-dropdown-menu">
                    <li class="nav-dropdown-item">
                        <a href="" class="nav-dropdown-item-link"><i class="fas fa-user-alt"></i> Profil</a>
                    </li>
                    <li class="nav-dropdown-item">
                        {{-- <a href="#" class="nav-dropdown-item-link text-danger">Logout</a> --}}
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" class="nav-dropdown-item-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
