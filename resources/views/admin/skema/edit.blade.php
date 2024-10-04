@extends('layouts.panel.index')
@section('content')
<style>
    .dropzone-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 130px; 
        border: 2px dashed #ddd;
        background-color: #f9f9f9;
        position: relative;
        cursor: pointer;
    }
    #image_preview {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%; 
        height: auto; 
        max-width: 100px; 
        max-height: 100px; 
        overflow: hidden;
        margin: 0 auto; 
    }
    #preview_image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; 
        display: block; 
    }
    </style>
    <div class="container mt-4">
        {{-- {{ dd($skema->path_icon) }} --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mt-2">Edit Skema</h5>
            </div>
            <div class="card-body">
                <div>
                    <form action="{{ route('skema.update', $skema->id_skema) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="page_id" class="form-label">Page Id</label>
                            <select class="form-select js-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page id"
                                    required>
                                    @foreach ($page as $set)
                                    <option value="{{ $set->id_page }}" {{ $set->id_page == $skema->page_id ? 'selected' : '' }}>{{ $set->nama_page }}</option>
                                    @endforeach
                                </select>
                        </div>
                        {{-- @dd($skema) --}}
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nama_skema" class="form-label">Nama Skema</label>
                                <input type="text" class="form-control" id="nama_skema" name="nama_skema" value="{{ $skema->nama_skema }}" required>
                            </div>
                            <div class="col">
								<label for="icon" class="mb-2">Upload Icon Skema</label>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>Pilih gambar atau seret ke sini.</p>
                                    </div>
                                    <input type="file" name="path_icon" class="dropzone" id="path_icon" accept="image/*">
                                    <div id="image_preview" class="mt-3">
                                        @if($skema->path_icon) <!-- Cek apakah ada gambar yang sudah ada -->
                                            <img id="preview_image" src="{{ asset($skema->path_icon) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <img id="preview_image" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @endif
                                    </div>
                                </div>
							</div>						
                        </div>

                        <div class="form-group sub-skema-wrapper mb-5">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">Sub Skema</label>

                                    <button type="button" class="btn btn-primary btn-sm rounded mb-2" id="addSubSkema">Tambah Sub-Skema</button>
                            </div>

                            @if(!$skema->has_sub_skema)
                                <div id="empty-input-message" class="alert alert-info" role="alert" style="display: show;">
                                    <h6 class="mx-3 mt-2">Tidak Memiliki Sub-Skema</h6>
                                </div>
                            @else
                                @foreach ($sub_skema as $row)
                                <div class="input-group mb-3 sub-skema-input">
                                    <input type="hidden" name="sub_skema_ids[]" value="{{ $row->id_sub_skema }}">
                                    <input type="text" class="form-control" name="sub_skema[{{ $row->id_sub_skema }}]" value="{{ $row->judul_sub }}" 
                                        placeholder="Nama Sub-Skema" required>
        
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger rounded removeSubSkema" type="button">Remove</button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>
                        <div class="modal-footer justify-content-between">
							<div class="form-check form-switch mb-3">
								<label for="status" class="me-3">Status</label>
								<input class="form-check-input" type="checkbox" role="switch" id="status"
									name="status" value="Aktif">
							</div>
							<div class="d-flex justify-content-end mb-2">
								<button type="submit" class="btn btn-success rounded text-white">Simpan Perubahan</button>
							</div>	
						</div>	
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    <script>
        $(document).ready(function() {
            $('#addSubSkema').click(function() {
                $('.sub-skema-wrapper').append('<div class="input-group mb-3 sub-skema-input">' +
                    '<input type="text" class="form-control" name="sub_skema[]" placeholder="Nama Sub-Skema" required>' +
                    '<button class="btn btn-outline-danger rounded removeSubSkema" type="button">Remove</button>' +
                    '</div>');

                $('#empty-input-message').hide();
            });

            $(document).on('click', '.removeSubSkema', function() {
                $(this).closest('.sub-skema-input').remove();
                checkEmptyInput();
            });

            function checkEmptyInput() {
				var inputs = $('input[name="sub_skema[]"]');
				if (inputs.length == 0) {
					$('#empty-input-message').show();
				} else {
					$('#empty-input-message').hide(); 
				}
			}
            $('input[type="file"]').on('change', function(event) {
                const fileInput = event.target;
                const preview = $('#preview_image'); // Pastikan ID ini sesuai

                const file = fileInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                        preview.show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file yang dipilih, tampilkan gambar yang sudah ada
                    const existingSrc = preview.attr('data-existing-src'); // Setel ini di HTML
                    preview.attr('src', existingSrc);
                }
            });

            Dropzone.options.path_file = {
            maxFilesize: 2, 
            acceptedFiles: "image/*", 
            init: function() {
                this.on("success", function(file, response) {                    
                });
                this.on("error", function(file, response) {
                    document.getElementById('image_error').innerHTML = response.message;
                });
              }
            };
        });
    </script>

    <script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush
