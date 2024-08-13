@extends('layouts.panel.index')

@section('title', 'Blog List')

@section('content')

<style>
    .blog-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        border-radius: 10px; /* Optional: add border-radius to the card for a smoother look */
    }

    .blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .blog-card img {
        width: 100%;
        height: 200px; /* Set a fixed height for images */
        object-fit: cover; /* Ensure image covers the area while maintaining aspect ratio */
        border-radius: 0; /* Ensure no border-radius is applied to the image */
    }

    .card-body {
        display: flex;
        flex-direction: column;
        padding: 1rem;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .card-text {
        flex-grow: 1; /* Allows the text to take up remaining space */
        margin-bottom: 1rem;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

@if ($blog)
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card blog-card h-100 shadow-sm">
                    <!-- Fallback to default image if photo is not set -->
                    <img src="{{ $blog->photo ? asset('storage/photos/' . $blog->photo) : asset('images/default.jpg') }}" class="card-img-top" alt="{{ $blog->judul }}">
                    <div class="card-body d-flex flex-column">
                        <h2 class="card-title mb-3">{{ $blog->judul }}</h2>
                        <p class="text-muted mb-4">{{ $blog->created_at->format('F j, Y') }}</p>
                        <div class="card-text">
                            {!! preg_replace('/<\/?p[^>]*>/', '', $blog->body) !!}
                        </div>
                        <a href="{{ route('blog.index') }}" class="btn btn-primary">Back to Blog List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- @else
    <p>No blog post found.</p>
@endif --}}

    {{-- <div class="alert alert-warning" role="alert">
        Blog not found.
    </div> --}}
@endif

@endsection
