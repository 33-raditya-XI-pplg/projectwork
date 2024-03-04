<nav class="navbar" id="panel-navbar">
    <div class="navbar-left">
        <button class="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars"></i></button>
    </div>
    <div class="navbar-right">
        <div class="nav-dropdown">
            <button class="nav-dropdown-btn">
                <div class="nav-dropdown-img">
                    <img src="{{ asset(auth()->user()->photo?? 'assets/img/default-profile.jpg') }}" alt="">
                </div>
                {{-- <span class="nav-dropdown-title">{{ auth()->user()->name }}</span> --}}
            </button>
            <div class="nav-dropdown-content">
                <ul class="nav-dropdown-menu">
                    <li class="nav-dropdown-item">
                        <a href="" class="nav-dropdown-item-link">Profil</a>
                    </li>
                    <li class="nav-dropdown-item">
                        <a href="#" class="nav-dropdown-item-link text-danger">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
