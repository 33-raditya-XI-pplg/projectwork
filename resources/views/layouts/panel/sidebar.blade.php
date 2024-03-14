<aside class="sidebar" id="panel-sidebar">
    <div class="sidebar-brand justify-content-center">
        <img id="logo" id="logo" src="{{ asset('assets/img/logo.png') }}" alt="0">

        <button id="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars text-primary" ></i></button>
    </div>
    <div class="sidebar-menu-content">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item {{ Request::segment(2) == 'dashboard'? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}" class="item-link">
                    <i class="fa fa-home link-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'event' ? 'active' : '' }}">
                <a href="{{ route('event.index') }}" class="item-link">
                    <i class="fas fa-bullhorn link-icon"></i>
                    <span>Event</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fas fa-tasks link-icon"></i>
                    <span>Penilaian</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'sertifikat' ? 'active' : '' }}">
                <a href="{{route('sertifikat.index')}}" class="item-link">
                    <i class="fas fa-award link-icon"></i>
                    <span>Sertifikat</span>
                </a>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'master' ? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fas fa-database link-icon"></i>
                    <span>Master Data</span>
                </a>
                <div class="sub-menu">
                    <ul class="sub-menu-content">
                        <li class="sub-menu-item {{ Request::segment(3) == 'instansi' ? 'active' : '' }}">
                            <a href="{{ route('instansi.index') }}" class="sub-menu-link"><i
                                    class="far fa-building"></i><span> Instansi</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'penguji' ? 'active' : '' }}">
                            <a href="{{ route('penguji.index') }}" class="sub-menu-link"><i class="fa fa-user"></i>
                                Penguji</a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'signature' ? 'active' : '' }}">
                            <a href="{{ route('signature.index') }}" class="sub-menu-link"><i
                                    class="fas fa-pen-alt"></i> Tanda tangan</a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'background' ? 'active' : '' }}">
                            <a href="{{ route('background.index') }}" class="sub-menu-link"><i
                                    class="fas fa-desktop"></i> Background</a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'jenis-event' ? 'active' : '' }}">
                            <a href="{{ route('jenis-event.index') }}" class="sub-menu-link"><i
                                    class="fas fa-bullhorn"></i> Jenis event</a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'scheme' ? 'active' : '' }}">
                            <a href="{{ route('scheme.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                Skema</a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'user' ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="sub-menu-link"><i class="fas fa-users"></i>
                                Pengguna</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fa fa-user link-icon"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
        <div class="triangle"></div>
        <div class="triangles"></div>
        <div class="footer">
            <h6><i class="far fa-copyright"></i> 2024 Mascitra Konsultan IT</h6>
        </div>
    </div>
</aside>

@push('script')
<script>
    // Fungsi untuk menangani klik tombol sidebar
    document.getElementById("btn-show-sidebar").addEventListener("click", function() {
        // Mengambil semua elemen <span> di dalam sidebar
        var spans = document.querySelectorAll('.sidebar-menu span');
        var logo = document.getElementById('logo');
        var sidebar = document.getElementById('panel-sidebar');
        var button = document.getElementById('btn-show-sidebar');
        var breadcrumb = document.getElementById('breadcrumb');

        // Melooping semua elemen <span> dan menghapus teksnya
        spans.forEach(function(span) {
            span.textContent = ''; // Menghilangkan teks
            logo.style.visibility = 'hidden';
            sidebar.style.maxWidth = '90px';
            button.style.left = '50%';
            breadcrumb.style.display = 'none';
        });
    });
</script>
@endpush
