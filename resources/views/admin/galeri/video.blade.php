{{-- @extends('layouts.panel.index')
@section('title', 'Dashboard')

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>
                </div>
                <a href="#myModal" data-toggle="modal" class="btn btn-primary btn-block mt-3">
                    <i class="fa fa-upload"></i> Upload YouTube Video
                </a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload YouTube Video</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('video.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="video_link">YouTube Video URL</label>
                            <input type="text" name="video_link" class="form-control" id="video_link" placeholder="Enter YouTube video URL" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> --}}
