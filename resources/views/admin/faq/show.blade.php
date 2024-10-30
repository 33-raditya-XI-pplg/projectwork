@extends('layouts.panel.index')
@section('title','Detail Faq')

@section('content')
<style>
    .card {
        perspective: 1000px;
        position: relative;
        overflow: hidden;
        height: 300px;
    }
    .card-body {
        position: relative;
        z-index: 1;
    }
    .card-front, .card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        transition: transform 0.6s;
    }
    .card-front {
        background: linear-gradient(135deg, #007bff, #00d2ff);
    }
    .card-back {
        transform: rotateY(180deg);
    }
    .card:hover .card-front {
        transform: rotateY(180deg);
    }
    .card:hover .card-back {
        transform: rotateY(0deg);
    }
    .form-control {
    background-color: #e5e8ec;
    border: 1px solid #ced4da;
    padding: 10px;
    border-radius: 4px;
}
</style>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="page" class="form-label"><h5>Page Id</h5></label>
                    <input class="form-control" value="{{ \App\Models\Page::find($faq->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
                </div>                  
                <div class="mb-3 ">
                    <label for="pengalaman" class="form-label"><h5>Pertanyaan</h5></label>
                    <di class="form-control"  rows="2" disabled readonly>{!! $faq->pertanyaan !!}</di>
                </div>   
                <div class="mb-3 ">
                    <label for="pengalaman" class="form-label"><h5>Jawaban</h5></label>
                    <di class="form-control"  rows="2" disabled readonly>{!! $faq->jawaban !!}</di>
                </div>          
      
                <div class="bg-light rounded-4 px-4 py-4 mb-2 shadow-lg">
                    <div class="container">
                        <div class="row">
                            @for ($i = 0; $i < $count; $i++)
                                <div class="col-md-4 mb-3">
                                    <div class="card border-0 rounded-3 overflow-hidden shadow-lg">
                                        <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                                        
                                            <div class="card-front bg-primary text-white rounded-3 p-4 d-flex align-items-center justify-content-center">
                                                <h5 class="mb-0">
                                                    <span class="badge bg-primary">{{ $i + 1 }}</span>
                                                    {!! $pertanyaanList[$i] !!}
                                                </h5>
                                            </div>
                                        
                                            <div class="card-back d-flex align-items-center justify-content-center p-4 text-dark bg-light rounded-3 position-absolute w-100 h-100">
                                                <p class="mb-0">
                                                    <span class="badge bg-info ">{{ $i + 1 }}</span>
                                                    {!! $jawabanList[$i] !!}
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- back --}}
                    <div class=" text-end">
                        <a href="{{ route('faq.indek') }}" class="btn btn-secondary">Kembali</a>
                    </div>
        </div>
    </div>     
@endsection