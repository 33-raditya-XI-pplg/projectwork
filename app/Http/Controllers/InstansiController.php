<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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

      $checkChildID1 = DB::table('tb_user')
                  ->where('instansi_id', $id)->count();
      $checkChildID2 = DB::table('tb_event')
                  ->where('instansi_id', $id)->count();
      $checkChildID3 = DB::table('tb_ttd')
                  ->where('instansi_id', $id)->count();

      if ($checkChildID1 > 0 || $checkChildID2 > 0 || $checkChildID3 > 0) {
          Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
          return redirect()->back();
      }

      unlink(public_path($logo));
      Instansi::destroy($id);
      toast('Instansi berhasil dihapus.', 'success');

      return redirect()->back();
   }
}
