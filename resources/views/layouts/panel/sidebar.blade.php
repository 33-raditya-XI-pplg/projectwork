<aside class="sidebar" id="panel-sidebar">
    <div class="sidebar-brand">
        <img class="logo" src="{{ asset('assets/img/logo.png') }}" alt="0">

        <button id="btn-show-sidebar" data-toggle="sidebar"><i class="fa fa-bars text-secondary " ></i></button>
    </div>
    <div class="sidebar-menu-content">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
                @auth
                    @if(optional(Auth::user())->level == 'Pengguna')
                        <a href="{{ url('user/dashboard') }}" class="item-link">
                            <i class="fa fa-home link-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ url('admin/dashboard') }}" class="item-link">
                            <i class="fa fa-home link-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                @else
                    <!-- Code for guests or unauthorized access -->
                    <a href="{{ url('login') }}" class="item-link">
                        <i class="fa fa-sign-in link-icon"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </li>

            @auth
            @if(optional(Auth::user())->level == 'Admin')
                <li class="sidebar-menu-item devider {{ Request::segment(2) == 'event' ? 'active' : '' }}">
                    <a href="{{ route('event.index') }}" class="item-link">
                        <i class="fas fa-bullhorn link-icon"></i>
                        <span>Event</span>
                    </a>
                </li>
                <li class="sidebar-menu-item devider {{ Request::segment(2) == 'penilaian' ? 'active' : '' }}">
                    <a href="{{ route('penilaian.index') }}" class="item-link">
                        <i class="fas fa-tasks link-icon"></i>
                        <span>Penilaian</span>
                    </a>
                </li>
                <li class="sidebar-menu-item devider {{ Request::segment(2) == 'sertifikat' ? 'active' : '' }} position-relative">
                    <a href="{{ route('sertifikat.index') }}" class="item-link">
                        <i class="fas fa-award link-icon"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
            @endif
        @endauth

        @auth
            @if(Auth::user()->level == 'Pengguna')
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'event-user' ? 'active' : '' }}">
                <a href="{{ route('event-user.index') }}" class="item-link">
                    <i class="fas fa-bullhorn link-icon"></i>
                    <span>Event</span>
                </a>
            </li>
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'sertifikat-user' ? 'active' : '' }} position-relative">
                <a href="{{route('sertifikat-user.index')}}" class="item-link">
                    <i class="fas fa-award link-icon"></i>
                    <span>Sertifikat</span>
                </a>
            </li>

            @endif
            @endauth
            @auth
            @if(Auth::user()->level == 'Admin')
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'master' ? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fas fa-database link-icon"></i>
                    <span>Master Data</span>
                </a>
                <div class="card-header mt-3" style="background-color:rgba(244, 244, 244, 1);border-radius:10px;">
                <div class="sub-menu">
                    <ul class="sub-menu-content">
                        <small class="text-muted">USER</small>
                        <li class="sub-menu-item {{ Request::segment(3) == 'penguji' ? 'active' : '' }}">
                            <a href="{{ route('penguji.index') }}" class="sub-menu-link"><i class="fa fa-user"></i>
                                <span> Penguji</span></a>
                        <li class="sub-menu-item {{ Request::segment(3) == 'user' ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="sub-menu-link"><i class="fas fa-users"></i>
                                <span> Pengguna</span></a>
                        </li>
                        <small class="text-muted">SKEMA</small>
                        <li class="sub-menu-item {{ Request::segment(3) == 'jenis-event' ? 'active' : '' }}">
                            <a href="{{ route('jenis-event.index') }}" class="sub-menu-link"><i
                                    class="fas fa-bullhorn"></i><span> Jenis Event</span></a>
                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'skema' ? 'active' : '' }}">
                            <a href="{{ route('skema.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Skema</span></a>
                        </li>
                        <small class="text-muted">DATA</small>
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
                        <li class="sub-menu-item {{ Request::segment(3) == 'instansi' ? 'active' : '' }}">
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
            @endif
            @endauth

            {{-- start --}}
            @auth

            @if(Auth::user()->level == 'Admin')
            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'website' ? 'active' : '' }}">
                <a href="" class="item-link">
                    <i class="fas fa-file link-icon"></i>
                    <span>Manajemen Website</span>
                </a>
                <div class="card-header mt-3" style="background-color:rgba(244, 244, 244, 1);border-radius:10px;">
                <div class="sub-menu">
                    <ul class="sub-menu-content">
                        {{-- <small class="text-muted">USER</small> --}}
                        <li class="sub-menu-item {{ Request::segment(3) == 'blog' ? 'active' : '' }}">
                            <a href="{{ route('blog.index') }}" class="sub-menu-link"><i class="fa fa-user"></i>
                                <span> Blog</span></a>

                        {{-- <small class="text-muted">SKEMA</small> --}}

                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'kategori' ? 'active' : '' }}">
                            <a href="{{ route('kategori.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Kategori</span></a>
                        </li>

                        <li class="sub-menu-item {{ Request::segment(3) == 'photos' ? 'active' : '' }}">
                            <a href="{{ route('galeri.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span>Photos</span></a>
                        </li>

                        <li class="sub-menu-item {{ Request::segment(3) == 'video' ? 'active' : '' }}">
                            <a href="{{ route('video.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span>Videos</span></a>
                        </li>
                        {{-- <small class="text-muted">DATA</small> --}}

                        </li>
                        <li class="sub-menu-item {{ Request::segment(3) == 'page' ? 'active' : '' }}">
                            <a href="{{ route('page.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Page</span></a>
                        </li>

                        <li class="sub-menu-item {{ Request::segment(3) == 'profile' ? 'active' : '' }}">
                            <a href="{{ route('profil.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span>Profile Perusahaan </span></a>
                        </li>

                        <li class="sub-menu-item {{ Request::segment(3) == 'page' ? 'active' : '' }}">
                            <a href="{{ route('partner.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Partner</span></a>
                        </li>

                        <li class="sub-menu-item {{ Request::segment(3) == 'page' ? 'active' : '' }}">
                            <a href="{{ route('blogkategori.index') }}" class="sub-menu-link"><i class="fas fa-retweet"></i>
                                <span> Blog Kategori</span></a>
                        </li>



                        </li>


                    </ul>
                </div>
                </div>
            </li>
            @endif
            @endauth

            {{-- end --}}

            <li class="sidebar-menu-item devider {{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                <a href="{{ route('profile.index') }}" class="item-link">
                    <i class="fa fa-user link-icon"></i>
                    <span>Profile</span>
                </a>
            </li>
        </ul>
        @auth


        @if(Auth::user()->level == 'Pengguna')
        <div class="level" style="margin-top:325px"></div>
        @endif
        @endauth
        @auth
        @if(Auth::user()->level == 'Penguji')
        <div class="level" style="margin-top:215px"></div>
        @endif
        @endauth
        @auth
        @if(Auth::user()->level == 'Admin')
        <div class="level" style="margin-top:197px"></div>
        @endif
        @endauth
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
