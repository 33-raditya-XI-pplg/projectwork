<nav class="navbar" id="panel-navbar">
    <div class="navbar-left">
        <button id="btn-show-sidebar-nav" data-toggle="sidebar" class="d-none"><i class="fa fa-bars text-secondary " ></i></button>
    </div>

    <div class="navbar-right">
        <div class="nav-dropdown">
            @auth
                <button class="nav-dropdown-btn">
                    <div class="nav-dropdown-img">
                        <img src="{{ asset('assets/img/icon.png') }}" alt="0">
                    </div>
                    <div class="users-login ml-10">
                        {{ Auth::user()->nama_lengkap }}
                        <h6 id="roles">{{ Auth::user()->level }}<i class="fa-solid fa-caret-down ms-2"></i></h6>
                    </div>
                </button>
                <div class="nav-dropdown-content" style="border-radius: 7px">
                    <ul class="nav-dropdown-menu">
                        <li class="nav-dropdown-item">
                            <a href="{{ route('profile-admin.index') }}" class="nav-dropdown-item-link"><i class="fas fa-user-alt"></i> Profil</a>
                        </li>
                        <li class="nav-dropdown-item">
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();" class="nav-dropdown-item-link text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <button class="nav-dropdown-btn">
                    <div class="nav-dropdown-img">
                        <img src="{{ asset('assets/img/icon.png') }}" alt="0">
                    </div>
                    <div class="users-login ml-10">
                        Guest
                        <h6 id="roles">Visitor<i class="fa-solid fa-caret-down ms-2"></i></h6>
                    </div>
                </button>
                <div class="nav-dropdown-content" style="border-radius: 7px">
                    <ul class="nav-dropdown-menu">
                        <li class="nav-dropdown-item">
                            <a href="{{ route('login') }}" class="nav-dropdown-item-link"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>

</nav>
