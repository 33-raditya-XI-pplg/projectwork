@extends('layouts.panel.index')
@section('title','Detail Background')

@section('content')
<style>
    .dropzone-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 240px;
    border: 2px dashed #ddd;
    background-color: #f9f9f9;
    position: relative;
    cursor: pointer; 
}
   #image_preview_ {
       display: flex;
       align-items: center;
       justify-content: center;
       width: 100%; 
       height: auto; 
       max-width: 350px; 
       max-height: 350px; 
       overflow: hidden;
       margin: 0 auto; 
   }  
</style>
    <div class="container">                          
        <div class="row">                                
                <div class="col mb-2">                                    
                    <label class="control-label mb-2"> Background</label>                                   
                    <div class="dropzone-wrapperr mx-auto">                                      
                            <div id="image_preview_" class="mt-3 d-flex justify-content-center">                                                
                                <img  src="{{ asset($background->path_bg) }}" alt="Image preview" class="img-fluid" style="max-width: auto; max-height: auto; object-fit: contain;">                                         
                            </div>                                                                      
                        </div>                                                                                                                                                                             
                </div>                                  
                <div class="mb-">
                    <label for="page" class="form-label">Page Id</label>
                    <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($background->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
                </div>
                <div class="mb-2">
                    <label for="nama_bg" class="form-label ">Nama Background</label>
                    <input class="form-control form-control-sm " id="nama_bg" name="nama_bg"
                        type="text" value="{{ $background->nama_bg }}" readonly disabled>
                </div>
                <div class="mb-2">
                    <label for="rincian_bg" class="form-label">Rincian</label>
                    <textarea class="form-control form-control-sm" id="rincian_bg" name="rincian_bg" rows="2" required disabled readonly  >{{ $background->rincian_bg }}</textarea>
                    {{-- <input class="form-control form-control-sm" id="rincian_bg" name="rincian_bg"
                        type="text" value="{{ $background->rincian_bg }}" readonly disabled> --}}
                </div>
                <div class="mb-2">
                    <label for="orientasi_bg" class="form-label">Orientation</label>
                    <select class="form-select" name="orientasi_bg" required disabled readonly >
                        <option {{ $background->orientasi_bg == 'landscape' ? 'selected' : '' }}>Landscape
                        </option>
                        <option {{ $background->orientasi_bg == 'potrait' ? 'selected' : '' }}>Potrait
                        </option>
                    </select>
                </div>  
                <div class=" text-end mx-1">
                    <a href="{{ route('background.index') }}" class="btn btn-secondary rounded">Kembali</a>
                </div>      
        </div>
    </div>                            
@endsection