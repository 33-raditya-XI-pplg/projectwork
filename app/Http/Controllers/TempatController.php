<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tempat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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

      Tempat::create($request->all());
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

      $tempat = Tempat::find($id);
      $tempat->update($request->all());
      Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

      return redirect()->back();
   }

   public function destroy($id)
   {
      $checkChildID = Event::where('tempat_id', $id)->count();

      if ($checkChildID > 0) {
          Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
          return redirect()->back();
      }
      
      Tempat::destroy($id);
      toast('Tempat berhasil dihapus.', 'success');

      return redirect()->back();
   }
}
