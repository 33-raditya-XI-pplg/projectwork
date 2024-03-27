<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use App\Models\Sub_Skema;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SkemaController extends Controller
{
    public function index() {
        // $data = Skema::with('skemaSub_Skema')->get();
        $data = Skema::get();

        confirmDelete('Hapus Skema', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.skema.index', compact('data'));
    }

    public function create() {
        return view('admin.skema.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {

            $skema = Skema::create([
                'nama_skema' => $request->nama_skema,
                'has_sub_skema' => $request->has('sub_skema') ? true : false,
                'status' => $request->has('status') ? $request->status : 'Nonaktif',
                'created_by' => Auth::user()->id_user,
            ]);
            
            if (!empty($request->sub_skema)) {
                foreach ($request->sub_skema as $nama_sub_skema) {
                    Sub_Skema::create([
                        'skema_id' => $skema->id_skema,
                        'judul_sub' => $nama_sub_skema,
                        'created_by' => Auth::user()->id_user,
                    ]);
                }
            }

            DB::commit();

            Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
            return redirect()->route('skema.index');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();

            Alert::error('Gagal Tersimpan!', 'Data gagal ditambahkan.' . $e->getMessage());
            return redirect()->route('skema.index');
        }
    }

    public function edit($id) {
        $skema = Skema::findOrFail($id);
        $sub_skema = Sub_Skema::all();

        return view('admin.skema.edit', compact('skema', 'sub_skema'));
    }

    public function update(Request $request, $id)
{

    // Cari skema yang akan diupdate
    $skema = Skema::findOrFail($id);

    // Memulai transaksi database
    DB::beginTransaction();
    try {
        // Update atribut skema
        $skema->nama_skema = $request->nama_skema;
        $skema->status = $request->has('status') ? $request->status : 'Nonaktif';

        // Simpan perubahan
        $skema->save();

        // Hapus semua sub-skema yang terkait dengan skema ini
        $skema->skemaSub_Skema()->delete();

        // Tambahkan kembali sub-skema yang baru dari request
        if (!empty($request->sub_skema)) {
            foreach ($request->sub_skema as $nama_sub_skema) {
                $skema->subSkemas()->create([
                    'judul_sub' => $nama_sub_skema,
                    'created_by' => Auth::user()->id_user,
                ]);
            }
        }

        // Commit transaksi jika semua operasi berhasil
        DB::commit();

        // Redirect atau memberikan respon jika berhasil
        return redirect()->route('skema.index')->with('success', 'Skema berhasil diperbarui.');
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollback();

        Alert::error('Gagal Tersimpan!', 'Data gagal ditambahkan.' . $e->getMessage());
        return redirect()->route('skema.index');
    }
}

    public function destroy($id)
    {
        Skema::destroy($id);
        toast('Skema berhasil dihapus.', 'success');

        return redirect()->route('skema.index');
    }
}
