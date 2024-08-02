@extends('layouts.panel.index')

@section('title', 'Dashboard')

@section('content')
    <h1>Video</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>
                </div>
                <a href="{{ route('video.create') }}" class="btn btn-primary btn-block mt-3" data-bs-toggle="modal" data-bs-target="#uploadVideoModal">Upload Video</a>
                {{-- <a href="{{ route('galeri.index') }}" class="btn btn-primary btn-block mt-3">Back</a> --}}
            </div>
        </div>
    </div>

    <!-- Table to display videos -->
    <div class="container mt-4">
        <div class="align-items-lg-center">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Video</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos as $video)
                                <tr>
                                    <td>
                                        @if(strpos($video->path_file, 'youtube.com') !== false || strpos($video->path_file, 'youtu.be') !== false)
                                            {{-- Embed YouTube video --}}
                                            @php
                                                // Extract YouTube video ID from URL
                                                $videoId = '';
                                                if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video->path_file, $matches)) {
                                                    $videoId = $matches[1];
                                                }
                                            @endphp
                                            @if($videoId)
                                                <iframe width="500" height="auto" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                                            @endif
                                        @else
                                            {{-- Display message for non-YouTube video URLs --}}
                                            <p>Invalid video URL</p>
                                        @endif
                                    </td>
                                    <td>{{ $video->deskripsi }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton{{ $video->id_galeri }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $video->id_galeri }}">
                                                <li>
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editVideoModal{{ $video->id_galeri }}">Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('video.destroy', $video->id_galeri) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No videos found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Edit Video Modals -->
                    @foreach($videos as $video)
                        <div class="modal fade" id="editVideoModal{{ $video->id_galeri }}" tabindex="-1" aria-labelledby="editVideoModalLabel{{ $video->id_galeri }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header -->
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
                                                <select name="kategori" class="form-control" required>
                                                    <option value="partner" {{ $video->kategori == 'partner' ? 'selected' : '' }}>Partner</option>
                                                    <option value="klien" {{ $video->kategori == 'klien' ? 'selected' : '' }}>Client</option>
                                                    <option value="gambar" {{ $video->kategori == 'gambar' ? 'selected' : '' }}>Image</option>
                                                    <option value="video" {{ $video->kategori == 'video' ? 'selected' : '' }}>Video</option>
                                                </select>
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
                                    <!-- Modal Footer -->
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                   <!-- Upload Video Modal -->
<div class="modal fade" id="uploadVideoModal" tabindex="-1" aria-labelledby="uploadVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="uploadVideoModalLabel">Upload Video</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
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
                        <select name="kategori" class="form-control" id="kategori" required>
                            <option value="partner">Partner</option>
                            <option value="klien">Client</option>
                            <option value="gambar">Image</option>
                            <option value="video">Video</option>
                        </select>
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
            <!-- Modal Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
