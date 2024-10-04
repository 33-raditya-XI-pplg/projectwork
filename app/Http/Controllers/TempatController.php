<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tempat;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TempatController extends Controller
{
   public function index()
   {
      $tempat = Tempat::get();
      $page = Page::all();
      $regencies = DB::table('regencies')->pluck('name', 'id');
      $Title = 'Master Data';
      $subtitle = 'Tempat';
      confirmDelete('Hapus Tempat', 'Apakah kamu yakin untuk mengapus tempat?');
      return view('admin.tempat.index', compact('tempat', 'page', 'regencies', 'Title', 'subtitle'));
   }

   public function store(Request $request)
   {
      //   if (!$request->has('status')) {
      //      $request->merge([
      //         'status' => 'Nonaktif'
      //      ]);
      //   }

      $request->validate([
         'page_id' => 'required|exists:tb_page,id_page',
      ]);


      Tempat::create([
         'page_id' => $request->page_id,
         'nama_tempat' => $request->nama_tempat,
         'alamat' => $request->alamat,
         'no_telp' => $request->no_telp,
         'alamat_kota' => $request->alamat_kota,
         'link_maps' => $request->link_maps,
         'created_by' => $request->created_by
      ]);
      Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan');
      // dd($request->all());
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
