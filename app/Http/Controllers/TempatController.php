<?php

namespace App\Http\Controllers;

use App\Models\Tempat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class TempatController extends Controller
{
   public function index()
   {
      $tempat = Tempat::get();

      confirmDelete('Hapus Tempat', 'Apakah kamu yakin untuk mengapus tempat?');
      return view('admin.tempat.index', compact('tempat'));
   }

   public function store(Request $request)
   {
    //   if (!$request->has('status')) {
    //      $request->merge([
    //         'status' => 'Nonaktif'
    //      ]);
    //   }

      tempat::create($request->all());
      Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan');

      return redirect()->back();
   }

   public function update(Request $request, $id)
   {
    //   if (!$request->has('status')) {
    //      $request->merge([
    //         'status' => 'Nonaktif'
    //      ]);
    //   }

      $tempat = tempat::find($id);
      $tempat->update($request->all());
      Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

      return redirect()->back();
   }

   public function destroy($id)
   {
      tempat::destroy($id);
      toast('Tempat berhasil dihapus.', 'success');

      return redirect()->back();
   }
}
