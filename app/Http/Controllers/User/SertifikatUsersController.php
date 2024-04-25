<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SertifikatUsersController extends Controller
{
    public function index()
    {
        return view('user.sertifikat.index');
    }
    public function cetak()
    {
        return view('user.sertifikat.cetak_sertifikat');
    }
}
