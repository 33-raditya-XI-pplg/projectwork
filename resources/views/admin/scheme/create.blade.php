@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header" style="background-color: #FFFFFF">
              <form action="">
                <div class="mb-3">
                  <label for="formFileSm" class="form-label">Nama Skema</label>
                  <input class="form-control form-control-sm" id="formFileSm" type="text">
                </div>
                <select class="form-select" aria-label="Default select example">
                  <option selected>Sub Skema</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
                <div class="d-flex justify-content-end mt-3">
                  <button class="btn btn-primary rounded">Tambah Sub Skema</button>
                </div>
                <div class="d-flex justify-content-end mt-8">
                  <button class="btn btn-success rounded text-white">Simpan</button>
                </div>
              </form>
            </div>
          </div>
    </div>
@endsection
