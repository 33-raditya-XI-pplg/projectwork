<aside class="sidebar" id="panel-sidebar">
    <div class="sidebar-brand justify-content-center">
        <img id="logo" src="{{ asset('assets/img/logo.png') }}" alt="0">

        <button id="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars text-secondary " ></i></button>
    </div>
    <div class="sidebar-menu-content">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'dashboard'? 'active' : '' }}">
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
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'sertifikat' ? 'active' : '' }}">
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
                        <li class="sub-menu-item {{ Request::segment(3) == 'instansi' ? 'active' : '' }}">
                            <a href="{{ route('instansi.index') }}" class="sub-menu-link"><i
                                    class="far fa-building"></i><span> Instansi</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'penguji' ? 'active' : '' }}">
                            <a href="{{ route('penguji.index') }}" class="sub-menu-link"><i class="fa fa-user"></i>
                                <span> Penguji</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'tandatangan' ? 'active' : '' }}">
                            <a href="{{ route('tandatangan.index') }}" class="sub-menu-link"><i
                                    class="fas fa-pen-alt"></i><span> Tanda Tangan</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'background' ? 'active' : '' }}">
                            <a href="{{ route('background.index') }}" class="sub-menu-link"><i
                                    class="fas fa-desktop"></i><span> Background</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'jenis-event' ? 'active' : '' }}">
                            <a href="{{ route('jenis-event.index') }}" class="sub-menu-link"><i
                                    class="fas fa-bullhorn"></i><span> Jenis Event</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'skema' ? 'active' : '' }}">
                            <a href="{{ route('skema.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Skema</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'user' ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="sub-menu-link"><i class="fas fa-users"></i>
                                <span> Pengguna</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'tempat' ? 'active' : '' }}">
                            <a href="{{ route('tempat.index') }}" class="sub-menu-link"><i class="fas fa-house-user"></i>
                                <span> Tempat</span></a>
                        </li>
                    </ul>
                </div>
                </div>
            </li>
            <li class="sidebar-menu-item {{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                <a href="{{ route('profile.index') }}" class="item-link">
                    <i class="fa fa-user link-icon"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
        <div id="segitiga">
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
    // Fungsi untuk menangani klik tombol sidebar
    var sidebarState = false; // Menyimpan status sidebar terbuka atau tertutup

    document.getElementById("btn-show-sidebar").addEventListener("click", function() {
        // Mengambil semua elemen <span> di dalam sidebar
        var spans = document.querySelectorAll('.sidebar-menu span');
        var logo = document.getElementById('logo');
        var sidebar = document.getElementById('panel-sidebar');
        var button = document.getElementById('btn-show-sidebar');
        var triangle = document.getElementById('segitiga');
        var footer = document.getElementById('footer');

        // Jika sidebar sedang terbuka
        if (sidebarState) {
            // Melooping semua elemen <span> dan mengembalikan teksnya
            spans.forEach(function(span) {
                span.style.display = ''; // Mengembalikan teks
            });
            logo.style.visibility = 'visible'; // Menampilkan kembali logo
            sidebar.style.maxWidth = '260px'; // Mengembalikan lebar sidebar ke kondisi semula
            button.style.left = '85%'; // Mengembalikan posisi tombol
            triangle.style.display = '';
            footer.style.display = '';
            sidebarState = false; // Menandakan sidebar kembali tertutup
        } else { // Jika sidebar sedang tertutup
            // Melooping semua elemen <span> dan menghapus teksnya
            spans.forEach(function(span) {
                span.style.display = 'none'; // Menghilangkan teks
            });
            logo.style.visibility = 'hidden'; // Menyembunyikan logo
            sidebar.style.maxWidth = '90px'; // Mengubah lebar sidebar
            button.style.left = '50%'; // Mengubah posisi tombol
            triangle.style.display = 'none';
            footer.style.display = 'none';
            sidebarState = true; // Menandakan sidebar sedang terbuka
        }
    });
</script>

@endpush
