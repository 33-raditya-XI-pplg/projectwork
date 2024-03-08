<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use function Laravel\Prompts\confirm;

class JenisEventController extends Controller
{
    public function index() {

        confirmDelete('Hapus Jenis Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.jenis-evt.index');
    }

    public function store() {

        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }

    public function update() {

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        
        return redirect()->back();
    }

    public function destroy() {

        toast('Jenis Event Terhapus', 'success');
        return redirect()->back();
    }
}
