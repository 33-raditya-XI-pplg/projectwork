<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class InstansiController extends Controller
{
   public function index()
   {
      $instansi = Instansi::get();
      $page = Page::all();
      $Title = 'Master Data';
      $subtitle = 'Instansi';
      // $regencies = DB::table('regencies')->pluck('name', 'id');
      confirmDelete('Hapus Instansi', 'Apakah kamu yakin untuk mengapus instansi?');
      return view('admin.instansi.index', compact('instansi', 'page', /*'regencies',*/ 'Title', 'subtitle'));
   }

   public function store(Request $request)
   {
      $request->validate([
         'email' => 'required|email|unique:tb_instansi,email|regex:/^.+@gmail\.com$/'
      ], [
         'email.required' => 'Email harus diisi.',
         'email.email' => 'Silakan masukan alamat email yang valid.',
         'email.unique' => 'Email sudah terdaftar.',
         'email.regex' => 'Hanya alamat gmail yang diperboleh kan .',
      ]);
      if (!$request->has('status')) {
         $request->merge([
            'status' => 'Nonaktif'
         ]);
      }

      $data = $request->all();
      if ($request->hasFile('path_logo')) {
         $logo = $request->file('path_logo');
         $filename = 'logo_' . $request->nomor_induk . '.' . $logo->getClientOriginalExtension();
         $storedPath = $logo->storeAs('public/logo_instansi', $filename);
         Storage::url($storedPath);
         $data = $request->except(['path_logo']);
         $data['path_logo'] = "/storage/logo_instansi/$filename";
      }

      Instansi::create($data);
      Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan');

      return redirect()->back();
   }

   public function update(Request $request, $id)
   {

      $instansi = Instansi::find($id);

      if (!$request->has('status')) {
         $request->merge([
            'status' => 'Nonaktif'
         ]);
      }

      $data = $request->except(['path_logo']);

      if ($request->has('path_logo')) {
         if ($instansi->path_logo) {
            $oldPhotoPath = str_replace('/storage', 'public', $instansi->path_logo);
            if (Storage::exists($oldPhotoPath)) {
               Storage::delete($oldPhotoPath);
            }
         }
         $logo = $request->file('path_logo');
         $filename = 'logo_' . $request->nomor_instansi . '.' . $logo->getClientOriginalExtension();
         $storedPath = $logo->storeAs('public/logo_instansi', $filename);
         Storage::url($storedPath);
         $data = $request->except(['path_foto']);
         $data['path_logo'] = "/storage/logo_instansi/$filename";
      }


      $instansi->update($data);
      Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

      return redirect()->back();
   }

   public function show($id)
   {
      $instansi = Instansi::findOrFail($id);
      $Title = 'Management';
      $subtitle = 'Detail Instansi';
      return view('admin.instansi.show', compact('instansi', 'Title', 'subtitle'));
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

      if (!empty($logo)) {
         if (file_exists(public_path($logo))) {
            unlink(public_path($logo));
            Instansi::destroy($id);
         } else {
            Instansi::destroy($id);
         }
      } else {
         Instansi::destroy($id);
      }

      toast('Instansi berhasil dihapus.', 'success');

      return redirect()->back();
   }
}
