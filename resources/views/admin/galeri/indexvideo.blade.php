@extends('layouts.panel.index')

@section('title', 'Dashboard')

@section('content')

@push('style')



<style>

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
</style>

@endpush


    <h1>Video Management</h1>
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('video.create') }}" class="btn btn-primary btn-block mt-3" data-bs-toggle="modal" data-bs-target="#uploadVideoModal">Upload Video</a>
            </div>
        </div>
    </div> --}}

    <!-- Table to display videos -->
    <div class="container mt-4">
        <div class="video-container">
            @forelse($videos as $video)
                <div class="video-item">
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
                    <div class="desc">{{ $video->deskripsi }}</div>
                    <div class="button-container">
                        <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $video->id_galeri }}">Edit</a>
                        <form action="{{ route('video.destroy', $video->id_galeri) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center">No videos found</p>
            @endforelse
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
                            <button type="submit" class="btn btn-primary btn-block">Update Video</button>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <h5 class="modal-title" id="uploadVideoModalLabel">Upload Video</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('video.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Name</label>
                            <input type="text" name="nama" class="form-control" id="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="page_id">Page ID</label>
                            <select name="page_id" class="form-control" id="page_id" required>
                                <option value="">Select Page ID</option>
                                @foreach ($pages as $page)
                                    <option value="{{ $page->id_page }}">{{ $page->id_page }} - {{ $page->nama_page }}</option>
                                @endforeach
                            </select>
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
                            <input type="url" name="path_file" class="form-control" id="path_file" placeholder="Enter YouTube video URL" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Description</label>
                            <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Enter description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Upload</button>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@push('script')
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

@endsection
