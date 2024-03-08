<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InstansiController extends Controller
{
   public function index() {

   confirmDelete('Hapus Instansi', 'Apakah kamu yakin untuk mengapus instansi?');

    return view('admin.instansi.index');
   } 

   public function store() {
      Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan');

      return redirect()->back();

   }

   public function update() {
      Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

      return redirect()->back();
   }

   public function destroy() {

      toast('Instansi berhasil dihapus.', 'success');

      return redirect()->back();
   }
}
