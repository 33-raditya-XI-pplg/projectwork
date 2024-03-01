<aside class="sidebar" id="panel-sidebar">
    <button class="btn-close-sidebar" data-toggle="sidebar">
        <i class="fa fa-xmark"></i>
    </button>
    <a href="{{ url('') }}" class="sidebar-brand">
        <img src="{{ asset('assets/img/logo.png') }}" alt="">
    </a>
    <div class="sidebar-menu-content">
        <ul class="sidebar-menu">
            <li>Menu</li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'dashboard'? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fa fa-home link-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'profile'? 'active' : '' }}">
                    <a href="" class="item-link">
                        <i class="fa fa-user link-icon"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'profile'? 'active' : '' }}">
                    <a href="" class="item-link">
                        <i class="fa fa-home link-icon"></i>
                        <span>Home</span>
                    </a>
                    <div class="sub-menu">
                        <ul class="sub-menu-content">
                            <li class="sub-menu-item">
                                <a href="" class="sub-menu-link">Dropdown #1</a>
                            </li>
                            <li class="sub-menu-item">
                                <a href="" class="sub-menu-link">Dropdown #2</a>
                            </li>
                            <li class="sub-menu-item">
                                <a href="" class="sub-menu-link">Dropdown #3</a>
                            </li>
                            <li class="sub-menu-item">
                                <a href="" class="sub-menu-link">Dropdown #4</a>
                            </li>
                        </ul>
                    </div>
                </li>
        </ul>
    </div>
</aside>