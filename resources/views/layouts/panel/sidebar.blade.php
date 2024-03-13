<aside class="sidebar" id="panel-sidebar">
    {{-- <button class="btn-close-sidebar" data-toggle="sidebar">
        <i class="fa fa-xmark"></i>
    </button> --}}
    <a class="sidebar-brand">
        <img src="{{ asset('assets/img/logo.png') }}" alt="0">
    </a>
        <button id="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars" ></i></button>
    <div class="sidebar-menu-content">
        <ul class="sidebar-menu">
            {{-- <li>Menu</li> --}}
            <li class="sidebar-menu-item {{ Request::segment(2) == 'dashboard'? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}" class="item-link">
                    <i class="fa fa-home link-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'event'? 'active' : '' }}">
                    <a href="{{ route('event.index') }}" class="item-link">
                        <i class="fas fa-bullhorn link-icon"></i>
                        <span>Event</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'profile'? 'active' : '' }}">
                    <a href="" class="item-link">
                        <i class="fas fa-tasks link-icon"></i>
                        <span>Penilaian</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'profile'? 'active' : '' }}">
                    <a href="" class="item-link">
                        <i class="fas fa-award link-icon"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'master'? 'active' : '' }}">
                    <a href="" class="item-link">
                        <i class="fas fa-database link-icon"></i>
                        <span>Master Data</span>
                    </a>
                    <div class="sub-menu">
                        <ul class="sub-menu-content">
                            <li class="sub-menu-item {{ Request::segment(3) == 'instansi'? 'active' : '' }}">
                                <a href="{{ route('instansi.index') }}" class="sub-menu-link"><i class="far fa-building"></i> Instansi</a>
                            </li>
                            <li class="sub-menu-item {{ Request::segment(3) == 'penguji'? 'active' : '' }}">
                                <a href="{{ route('penguji.index') }}" class="sub-menu-link"><i class="fa fa-user"></i> Penguji</a>
                            </li>
                            <li class="sub-menu-item {{ Request::segment(3) == 'signature'? 'active' : '' }}">
                                <a href="{{ route('signature.index') }}" class="sub-menu-link"><i class="fas fa-pen-alt"></i> Tanda tangan</a>
                            </li>
                            <li class="sub-menu-item {{ Request::segment(3) == 'background'? 'active' : '' }}">
                                <a href="{{ route('background.index') }}" class="sub-menu-link"><i class="fas fa-desktop"></i> Background</a>
                            </li>
                            <li class="sub-menu-item {{ Request::segment(3) == 'jenis-event'? 'active' : '' }}">
                                <a href="{{ route('jenis-event.index') }}" class="sub-menu-link"><i class="fas fa-bullhorn"></i> Jenis event</a>
                            </li>
                            <li class="sub-menu-item {{ Request::segment(3) == 'scheme'? 'active' : '' }}">
                                <a href="{{route('scheme.index')}}" class="sub-menu-link"><i class="fas fa-retweet"></i> Skema</a>
                            </li>
                            <li class="sub-menu-item {{ Request::segment(3) == 'user'? 'active' : '' }}">
                                <a href="{{ route('user.index') }}" class="sub-menu-link"><i class="fas fa-users"></i> Pengguna</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item {{ Request::segment(2) == 'profile'? 'active' : '' }}">
                    <a href="" class="item-link">
                        <i class="fa fa-user link-icon"></i>
                        <span>Profile</span>
                    </a>
                </li>
        </ul>
    </div>
</aside>
