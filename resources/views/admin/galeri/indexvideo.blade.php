@extends('layouts.panel.index')

@section('title', 'Dashboard')

@section('content')

@push('style')


<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<style>
.select2-close-mask{
        z-index: 2099 !important;
    }
    .select2-dropdown{
        z-index: 3051 !important;
    }
    .video-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 10px;
    }


    .video-item {
        position: relative;
        width: 100%;
        max-width: 800px;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
        margin-bottom: 20px;
    }

    .video-item:hover {
        border-color: #777;
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    }


    .video-item iframe {
        width: 100%;
        height: 450px;
    }


    .video-item .desc {
        padding: 15px;
        text-align: left;
        background: rgba(255, 255, 255, 0.9);
        border-top: 1px solid #ddd;
    }


    .video-item .button-container {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
        padding: 10px;
        background: rgba(255, 255, 255, 0.9);
    }

    .btn-group button,
    .btn-group form {
        margin: 0;
    }

    .btn-group button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-group button:hover {
        background-color: #0056b3;
    }

    .dropdown-menu {
        min-width: 160px;
    }

    .modal-content {
        border-radius: 8px;
        overflow: hidden;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-body {
        padding: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .video-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem; /* Adjust gap between items as needed */
    }

    .video-item {
        flex: 1 1 calc(25% - 1rem); /* 4 items per row with a gap */
        max-width: calc(25% - 1rem);
        max-height: 320px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .video-item iframe {
        max-height: 120px;
    }

    .desc {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        margin-bottom: 10px;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
    }
</style>

@endpush


    {{-- <h1>Video Management</h1> --}}
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('video.create') }}" class="btn btn-primary btn-block mt-3" data-bs-toggle="modal" data-bs-target="#uploadVideoModal">Upload Video</a>
            </div>
        </div>
    </div> --}}

    <form method="GET" action="{{ route('video.index') }}">
        <div class="d-flex align-items-center" style="margin-left: 20px;">             
            <div class="input-group" style="width: 250px;">
                <span class="input-group-text bg-primary text-white border-0">
                    <i class="fas fa-filter"></i>
                </span>
                <select name="filter" onchange="this.form.submit()" class="form-control" style="background-color: #0d76e7; color: white; border:none;">
                    <option value="" selected disabled>Cari Berdasarkan</option>
                    <option value="latest" {{ request('filter') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('filter') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="az" {{ request('filter') == 'az' ? 'selected' : '' }}>Nama</option>
                    <option value="page1" {{ request('filter') == 'page1' ? 'selected' : '' }}>Kategori LPK</option>
                    <option value="page2" {{ request('filter') == 'page2' ? 'selected' : '' }}>Kategori LSP</option>
                </select>
            </div>
            @if (request()->has('filter'))
            <a href="{{ route('galeri.index') }}" class="btn btn-danger">
                ✖ Reset
            </a>
        @endif
    </div>
    </form>

    <!-- Table to display videos -->
    <div class="container mt-4">
        <div class="video-section">
            {{-- <h4>Videos</h4> --}}
            <div class="video-container">
                @forelse($videos as $video)
                    <div class="video-item me-3 mb-3">
                        @if(strpos($video->path_file, 'youtube.com') !== false || strpos($video->path_file, 'youtu.be') !== false)
                            @php
                                $videoId = '';
                                if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video->path_file, $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            @if($videoId)
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                            @endif
                        @else
                            <p>Invalid video URL</p>
                        @endif

                        <!-- Display Description -->
                        <div class="desc mt-2">
                            <strong>Description:</strong> {{ $video->deskripsi }}
                        </div>

                        <!-- Edit and Delete Buttons -->
                        <div class="button-container mt-2">
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $video->id_galeri }}">Edit</a>
                            <form id="deleteForm{{ $video->id_galeri }}" action="{{ route('video.destroy', $video->id_galeri) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-primary btn-sm" onclick="confirmDelete('{{ $video->id_galeri }}')">
                                    Delete
                                </button>
                            </form>
                        </div>
                        <script>
                            function confirmDelete(videoId) {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'Cancel'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('deleteForm' + videoId).submit();
                                    }
                                });
                            }
                        </script>
                    </div>
                @empty
                    <p class="text-center">No videos found</p>
                @endforelse
            </div>
        </div>
    </div>




    <!-- Edit Video Modals -->
    @foreach($videos as $video)
        <div class="modal fade" id="editVideoModal{{ $video->id_galeri }}" tabindex="-1" aria-labelledby="editVideoModalLabel{{ $video->id_galeri }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editVideoModalLabel{{ $video->id_galeri }}">Edit Video</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('video.update', $video->id_galeri) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama">Name</label>
                                <input type="text" name="nama" class="form-control" value="{{ $video->nama }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Category</label>
                                <select name="kategori" class="form-control" disabled>
                                    <option value="video" selected>Video</option>
                                </select>
                                <input type="hidden" name="kategori" value="video">
                            </div>
                            <div class="form-group">
                                <label for="path_file">Video URL</label>
                                <input type="url" name="path_file" class="form-control" value="{{ $video->path_file }}" placeholder="Enter YouTube video URL" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Description</label>
                                <textarea name="deskripsi" class="form-control" placeholder="Enter description" required>{{ $video->deskripsi }}</textarea>
                            </div>
                            <div class="modal-footer bg-light">
                                <div class="d-flex justify-content-end w-100">
                                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Update Video</button>
                                </div>
                            </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>
    @endforeach

    <!-- Upload Video Modal -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="uploadVideoModalLabel">Upload Video </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('video.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Name <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" id="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="page_id">Page ID <span class="text-danger">*</span></label>
                            <select name="page_id" class="form-control js-example-basic-single" id="page_id" data-placeholder="Pilih Page" required>
                                <option value="">Select Page ID</option>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id_page }}">{{ $page->id_page }} - {{ $page->nama_page }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori Otomatis terisi video</label>

                            <!-- Hint text displayed as a read-only input field -->
                            <input type="text" class="form-control" value="Video" readonly style="background-color: #ADD8E6;">

                            <!-- The actual select field is hidden but still submitted with the form -->
                            <select name="kategori" class="form-control d-none">
                                <option value="video" selected>Video</option>
                            </select>

                            <input type="hidden" name="kategori" value="video">
                        </div>


                        <div class="form-group">
                            <label for="path_file">Video URL <span class="text-danger">*</span></label>
                            <input type="url" name="path_file" class="form-control" id="path_file" placeholder="Enter YouTube video URL" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="deskripsi">Description <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Enter description" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>


                    </form>
                </div>
                <div class="modal-footer bg-light">

                </div>
            </div>
        </div>
    </div>

@push('script')

<!-- Include CSS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include JS Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
  $(document).ready(function() {
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder'); 
            
            $(this).select2({
                placeholder: placeholder, 
                allowClear: true,
                minimumResultsForSearch: Infinity 
            });
        });
    });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif


    @endpush

    @push('script')
<script>
    $(document).ready(function() {
        // [Workaround] Perbaikan HTML untuk placeholder di modal Tambah
        const addPageSelect = $('#add select[name="page_id"]');
        if (addPageSelect.length) {
            // Hapus opsi default yang bermasalah
            addPageSelect.find('option[value=""]').remove();
            // Tambahkan opsi kosong yang bersih di awal
            addPageSelect.prepend('<option value=""></option>');
            // Atur nilainya menjadi kosong agar placeholder muncul
            addPageSelect.val('').trigger('change');
        }
        
        // Inisialisasi Select2 untuk semua elemen
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder');
            var parentModal = $(this).closest('.modal');

            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                theme: "bootstrap-5",
                dropdownParent: parentModal 
            });
        });

        // Mengatur placeholder untuk KOTAK PENCARIAN
        $('.js-example-basic-single').on('select2:open', function(e) {
            var searchField = document.querySelector('.select2-search__field');
            if (searchField) {
                searchField.placeholder = 'Cari Page...';
            }
        });
    });
</script>
@endpush
@endsection
