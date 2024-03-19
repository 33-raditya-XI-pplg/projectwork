@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class="bg-white rounded-4 px-3 py-3 mb-4 shadow-lg" style="font-family:sans-serif">
            <div class="card-title mb-2" style="color: black;font-weight:bold;margin-left:8px;font-size:20px">Input Nilai</div>
            <table class="table" style="border: transparent">
                <tbody>
                  <tr>
                    <td style="width:15%">Nama Peserta</td>
                    <td style="width:5%">:</td>
                    <td style="width:80%">Dedi Hariyanto</td>
                  </tr>
                  <tr>
                    <td style="width:15%">Skema</td>
                    <td style="width:5%">:</td>
                    <td style="width:80%">It Support</td>
                  </tr>
                  <tr>
                    <td style="width:15%">Lorem Ipsum</td>
                    <td style="width:5%">:</td>
                    <td style="width:80%">Lorem Ipsum</td>
                  </tr>
                </tbody>
              </table>
        </div>
        <div class="bg-white rounded-4 px-3 py-3 shadow-lg">
            <form action="">
                  <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Sub Skema</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputPassword">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Sub Skema</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputPassword">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Sub Skema</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputPassword">
                    </div>
                  </div>
                  <button class="btn btn-sm btn-danger rounded">Cancel</button>
                  <button class="btn btn-sm btn-primary rounded">Submit</button>
            </form>
        </div>
    </div>
@endsection
