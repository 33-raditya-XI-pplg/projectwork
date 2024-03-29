@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
				<h5>Create Skema</h5>
            </div>
			<div class="card-body">
                <div>
					<form action="{{ route('skema.store') }}" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="row mb-3">
							<div class="col">
								<label for="nama_skema" class="form-label">Nama Skema</label>
								<input type="text" class="form-control" id="nama_skema" name="nama_skema" required>
							</div>
							<div class="col">
								<label for="icon" class="mb-2">Icon Skema</label>
								<input class="form-control" name="icon" type="file" id="formFile" accept=".png" required>
							</div>						
						</div>
						<div class="form-group sub-skema-wrapper mb-5">
							<div class="d-flex justify-content-between">
								<label class="form-label">Sub Skema</label>
								<button type="button" class="btn btn-primary btn-sm rounded mb-2" id="addSubSkema">Tambah Sub-Skema</button>
							</div>

							<!-- <div id="empty-input-message" class="alert alert-info" role="alert" style="display: hide;">
								<p class="mb-1 mx-2">Sub-Skema Kosong</p>
							</div> -->

							<div class="input-group mb-3 sub-skema-input">
								<!-- Input Dinamis -->
							</div>
						</div>

						<hr>
						<div class="modal-footer justify-content-between">
							<div class="form-check form-switch mb-3">
								<label for="status" class="me-3">Status</label>
								<input class="form-check-input" type="checkbox" role="switch" id="status"
									name="status" value="Aktif">
							</div>
							<div class="d-flex justify-content-end mb-2">
								<button type="submit" class="btn btn-success rounded text-white">Simpan</button>
							</div>	
						</div>	
					</form>
				</div>

            </div>
          </div>
    </div>
@endsection

@push('script')
    <script>
		$(document).ready(function() {
            $('#addSubSkema').click(function() {
                $('.sub-skema-wrapper').append('<div class="input-group mb-3 sub-skema-input">' +
                    '<input type="text" class="form-control" name="sub_skema[]" placeholder="Nama Sub-Skema" required>' +
                    '<button class="btn btn-outline-danger rounded removeSubSkema" type="button">Remove</button>' +
                    '</div>');
            });

            $(document).on('click', '.removeSubSkema', function() {
                $(this).closest('.sub-skema-input').remove();
            });
        });
        // $(document).ready(function() {
		// 	$('#addSubSkema').click(function() {
		// 		$('.sub-skema-wrapper').append('<div class="input-group mb-3 sub-skema-input">' +
		// 			'<input type="text" class="form-control" name="sub_skema[]" placeholder="Nama Sub-Skema" required>' +
		// 			'<button class="btn btn-outline-danger rounded removeSubSkema" type="button">Remove</button>' +
		// 			'</div>');
		// 		$('#empty-input-message').hide();
		// 	});

		// 	$(document).on('click', '.removeSubSkema', function() {
		// 		$(this).closest('.sub-skema-input').remove();
		// 		checkEmptyInput(); 
		// 	});

		// 	function checkEmptyInput() {
		// 		var inputs = $('input[name="sub_skema[]"]');
		// 		if (inputs.length == 0) {
		// 			$('#empty-input-message').show(); 
		// 		} else {
		// 			$('#empty-input-message').hide(); 
		// 		}
		// 	}
		// });
    </script>

	<script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush
