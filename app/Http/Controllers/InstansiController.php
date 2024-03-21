<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class InstansiController extends Controller
{
   public function index()
   {
      $instansi = Instansi::get();

      confirmDelete('Hapus Instansi', 'Apakah kamu yakin untuk mengapus instansi?');
      return view('admin.instansi.index', compact('instansi'));
   }

   public function store(Request $request)
   {
      if (!$request->has('status')) {
         $request->merge([
            'status' => 'Nonaktif'
         ]);
      }

      $logo = $request->file('logo');
      $filename = 'logo_' . $request->nomor_instansi . '.' . $logo->getClientOriginalExtension();
      $stored = $logo->storeAs('public/logo_instansi', $filename);

      $request->merge([
         'path_logo' => Storage::url($stored),
      ]);

      Instansi::create($request->all());
      Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan');

      return redirect()->back();
   }

   public function update(Request $request, $id)
   {
      dd($request->all());
      if (!$request->has('status')) {
         $request->merge([
            'status' => 'Nonaktif'
         ]);
      }

      if ($request->has('logo')) {
         $logo = $request->file('logo');
         $filename = 'logo_' . $request->nomor_instansi . '.' . $logo->getClientOriginalExtension();
         $logo->storeAs('public/logo_instansi', $filename);
      }

      $instansi = Instansi::find($id);
      $instansi->update($request->all());
      Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

      return redirect()->back();
   }

   public function destroy($id)
   {
      $logo = Instansi::find($id)->path_logo;
      unlink(public_path($logo));
      Instansi::destroy($id);
      toast('Instansi berhasil dihapus.', 'success');

      return redirect()->back();
   }
}
