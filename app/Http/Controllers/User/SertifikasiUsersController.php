<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SertifikasiUsersController extends Controller
{
    public function index()
    {
        return view('user.sertifikasi.index');
    }
    public function cetak()
    {
        return view('user.sertifikasi.cetak_sertifikat');
    }
}
