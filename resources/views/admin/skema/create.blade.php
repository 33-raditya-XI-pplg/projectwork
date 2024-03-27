@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
				<form action="{{ route('skema.store') }}" method="POST">
					@csrf
					<input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
					<div class="mb-3">
						<label for="nama_skema" class="form-label">Nama Skema</label>
						<input type="text" class="form-control" id="nama_skema" name="nama_skema" required>
					</div>
					<div class="form-group sub-skema-wrapper mb-5">
						<div class="d-flex justify-content-between">
							<label class="form-label">Sub Skema</label>
						<button type="button" class="btn btn-primary btn-sm rounded mb-2" id="addSubSkema">Tambah Sub-Skema</button>
						</div>

						<div class="input-group mb-3 sub-skema-input">
							<input type="text" class="form-control" name="sub_skema[]" placeholder="Nama Sub-Skema" required>
							
							<div class="input-group-append">
								<button class="btn btn-outline-danger removeSubSkema" type="button">Remove</button>
							</div>
						</div>

					</div>

					<hr>
					<div class="form-check form-switch mb-3">
                        <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif">
                    </div>
					<div class="d-flex justify-content-end">
						<button type="submit" class="btn btn-success rounded text-white">Simpan</button>
					</div>			
				</form>
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
    </script>
@endpush