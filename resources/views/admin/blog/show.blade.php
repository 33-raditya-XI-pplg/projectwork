@extends('layouts.app')

@section('title', $blog->judul ?? 'Blog Details')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($blog)
                <div class="card">
                    <!-- Fallback to default image if logo is not set -->
                    <img src="{{ $blog->logo ? asset('storage/' . $blog->logo) : asset('images/default.jpg') }}" class="card-img-top" alt="{{ $blog->judul }}">
                    <div class="card-body">
                        <h2 class="card-title">{{ $blog->judul }}</h2>
                        <p class="text-muted mb-4">{{ $blog->created_at->format('F j, Y') }}</p>
                        <p>{{ $blog->body }}</p>
                        <a href="{{ route('blog.index') }}" class="btn btn-secondary">Back to Blog List</a>
                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    Blog not found.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
