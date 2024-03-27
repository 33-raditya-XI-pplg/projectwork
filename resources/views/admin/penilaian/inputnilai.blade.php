@extends('layouts.panel.index')
@section('content')
    <div class="container mt-4">
        <div class=" text-white rounded-4 px-4 py-3 mb-4 shadow-lg" style="font-family:sans-serif;background:linear-gradient(to right, #FD7906, #FF9900);">
            <div class="card-title mb-2 fw-bold" style="color: white;margin-left:8px;font-size:28px">Input Nilai</div>
            <table class="table text-white" style="border: transparent;font-size:20px">
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
        <div class="card-title rounded-top px-3 py-3 fw-semibold" style="color: white;font-size:20px;background:linear-gradient(to right, #FD7906, #FF9900);">Pematik</div>
        <div class="bg-white rounded-bottom px-3 py-4 shadow-lg">
            <form action="">
                  <div class="px-3 mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px;">Sub Skema</label>
                    <div class="col-sm-10 d-flex justify-content-end">
                      <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-2">Nilai</label>
                      <input type="text" class="form-control rounded-0 rounded-end text-center" style="width: 100px;" id="inputPassword">
                    </div>
                  </div>
                  <div class="px-3 mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label"style="font-size: 18px;">Sub Skema</label>
                    <div class="col-sm-10 d-flex justify-content-end">
                      <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-2">Nilai</label>
                      <input type="text" class="form-control rounded-0 rounded-end text-center" style="width: 100px;" id="inputPassword">
                    </div>
                  </div>
                  <div class="px-3 mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label"style="font-size: 18px;">Sub Skema</label>
                    <div class="col-sm-10 d-flex justify-content-end">
                      <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-2">Nilai</label>
                      <input type="text" class="form-control rounded-0 rounded-end text-center" style="width: 100px;" id="inputPassword">
                    </div>
                  </div>
                  <div class="px-3 mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label"style="font-size: 18px;">Sub Skema</label>
                    <div class="col-sm-10 d-flex justify-content-end">
                      <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-2">Nilai</label>
                      <input type="text" class="form-control rounded-0 rounded-end text-center" style="width: 100px;" id="inputPassword">
                    </div>
                  </div>
                  <div class="px-3 mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label"style="font-size: 18px;">Sub Skema</label>
                    <div class="col-sm-10 d-flex justify-content-end">
                      <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-2">Nilai</label>
                      <input type="text" class="form-control rounded-0 rounded-end text-center" style="width: 100px;" id="inputPassword">
                    </div>
                  </div>
                  <div class="my-4 mx-2 px-3 py-3 d-flex justify-content-end">
                  <button class="btn btn-sm btn-danger rounded mx-1 px-3 py-2 bg-dsnger">Cancel</button>
                  <button class="btn btn-sm btn-primary rounded mx-1 px-3 py-2 bg-success">Submit</button>
                  </div>
                  
            </form>
        </div>
    </div>
@endsection
