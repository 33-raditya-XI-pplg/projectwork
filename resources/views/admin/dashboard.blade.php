@extends('layouts.panel.index')
@section('title', 'Dashboard')
@section('content')

@endsection

@push('script')
    <script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush
