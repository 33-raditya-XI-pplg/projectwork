@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
              <form action="">
                <div>
                  <label for="formFileSm" class="form-label">Nama Skema</label>
                  <input class="form-control form-control-sm" id="formFileSm" type="text">
                </div>
                <div class="mt-3">
                  <label class="form-label">Sub Skema</label>
                <input type="text" class="form-control" id="sub">
                </div>
                <div id="list"></div>
                {{-- <div class="input-group mt-3">
                  <input type="text" class="form-control rounded" value="Lorem 1" aria-describedby="button-addon2" readonly>
                  <button class="btn btn-outline-danger rounded" type="button" id="button-addon2">Remove</button>
                </div> --}}
                <div class="d-flex justify-content-end mt-3">
                  <button id="addsub" type="button" class="btn btn-primary rounded">Tambah Sub Skema</button>
                </div>
                <div class="d-flex justify-content-end mt-8">
                  <button class="btn btn-success rounded text-white">Simpan</button>
                </div>
              </form>
            </div>
          </div>
    </div>
@endsection
@push('script')
    <script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
    <script>
      var input = document.getElementById('sub');

      $("#addsub").click(function() {
        add =  ' <div id="subskema"><div class="input-group mt-3">' +
                  '<input type="text" class="form-control rounded" value="' +input.value +'" aria-describedby="button-addon2" readonly>' +
                  '<button class="btn btn-outline-danger rounded" type="button" id="remove">Remove</button></div>'
        $('#list').append(add);
        input.value = '';
      });

      $("body").on("click", "#remove", function() {
        console.log('Remove');
        $(this).parents("#subskema").remove();
      })
    </script>
@endpush