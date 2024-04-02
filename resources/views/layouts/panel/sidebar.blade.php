<aside class="sidebar" id="panel-sidebar">
    <div class="sidebar-brand">
        <img class="logo" src="{{ asset('assets/img/logo.png') }}" alt="0">

        <button id="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars text-secondary " ></i></button>
    </div>
    <div class="sidebar-menu-content">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}" class="item-link">
                    <i class="fa fa-home link-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'event' ? 'active' : '' }}">
                <a href="{{ route('event.index') }}" class="item-link">
                    <i class="fas fa-bullhorn link-icon"></i>
                    <span>Event</span>
                </a>
            </li>
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'penilaian' ? 'active' : '' }}">
                <a href="{{route('penilaian.index')}}" class="item-link">
                    <i class="fas fa-tasks link-icon"></i>
                    <span>Penilaian</span>
                </a>
            </li>
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'sertifikat' ? 'active' : '' }} position-relative">
                <a href="{{route('sertifikat.index')}}" class="item-link">
                    <i class="fas fa-award link-icon"></i>
                    <span>Sertifikat</span>
                </a>
            </li>
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'master' ? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fas fa-database link-icon"></i>
                    <span>Master Data</span>
                </a>
                <div class="card-header mt-3" style="background-color:rgba(244, 244, 244, 1);border-radius:10px;">
                <div class="sub-menu">
                    <ul class="sub-menu-content">
                        <span class="text-muted">USER</span>
                        <li class="sub-menu-item {{ Request::segment(3) == 'penguji' ? 'active' : '' }}">
                            <a href="{{ route('penguji.index') }}" class="sub-menu-link"><i class="fa fa-user"></i>
                                <span> Penguji</span></a>
                        <li class="sub-menu-item {{ Request::segment(3) == 'user' ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="sub-menu-link"><i class="fas fa-users"></i>
                                <span> Pengguna</span></a>
                        </li>
                        <span class="text-muted">SKEMA</span>
                        <li class="sub-menu-item {{ Request::segment(3) == 'jenis-event' ? 'active' : '' }}">
                            <a href="{{ route('jenis-event.index') }}" class="sub-menu-link"><i
                                    class="fas fa-bullhorn"></i><span> Jenis Event</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'skema' ? 'active' : '' }}">
                            <a href="{{ route('skema.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Skema</span></a>
                        </li>
                        <span class="text-muted">DATA</span>
                        <li class="sub-menu-item {{ Request::segment(3) == 'tandatangan' ? 'active' : '' }}">
                            <a href="{{ route('tandatangan.index') }}" class="sub-menu-link"><i
                                    class="fas fa-pen-alt"></i><span> Tanda Tangan</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'background' ? 'active' : '' }}">
                            <a href="{{ route('background.index') }}" class="sub-menu-link"><i
                                    class="fas fa-desktop"></i><span> Background</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'rentang-nilai' ? 'active' : '' }}">
                            <a href="{{ route('rentang-nilai.index') }}" class="sub-menu-link"><i class="fa-solid fa-bezier-curve"></i>
                                <span> Rentang Nilai</span></a>
                        </li>
                        <span class="text-muted">TUK</span>
                        <li class="sub-menu-item {{ Request::segment(3) == 'instansi' ? 'active' : '' }} mt-2">
                            <a href="{{ route('instansi.index') }}" class="sub-menu-link"><i
                                    class="far fa-building"></i><span> Instansi</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'tempat' ? 'active' : '' }}">
                            <a href="{{ route('tempat.index') }}" class="sub-menu-link"><i class="fas fa-house-user"></i>
                                <span> Tempat</span></a>
                        </li>

                    </ul>
                </div>
                </div>
            </li>
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                <a href="{{ route('profile.index') }}" class="item-link">
                    <i class="fa fa-user link-icon"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
        <div id="segitiga" class="segitiga">
            <span class="triangle d-block"></span>
            <span class="triangles d-block"></span>
        </div>
        <div id="footer" class="footer">
            <h6><i class="far fa-copyright"></i> 2024 Mascitra Konsultan IT</h6>
        </div>
    </div>
</aside>



@push('script')
<script>
        var sidebarState = false; // Menyimpan status sidebar terbuka atau tertutup
        $(document).on('click', '#btn-show-sidebar', function() {
            var windowWidth = $(window).width();
            var sidebar = $('#panel-sidebar');
            if (windowWidth > 576) {
                // Jika sidebar sedang terbuka
                if (sidebarState) {
                    sidebar.removeClass('coll');
                    sidebarState = false; // Menandakan sidebar kembali tertutup
                } else { // Jika sidebar sedang tertutup
                    sidebar.addClass('coll');
                    sidebarState = true; // Menandakan sidebar sedang terbuka
                }
            }
        });
    </script>
@endpush
