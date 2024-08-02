<?php

namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Instansi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Kategori::all();
        $kategori = Kategori::orderBy('created_at', 'desc')->get();

        confirmDelete('Hapus kategori', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal Menyimpan!', 'Terjadi kesalahan saat menyimpan data.');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $request->deskripsi,
                'updated_by' => Auth::id(),
            ]);

            Alert::success('Berhasil Diperbarui!', 'Data berhasil diubah.');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal Memperbarui!', 'Terjadi kesalahan saat memperbarui data.');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->level == 'Kategori') {
            $checkChildID = DB::table('tb_menguji')
                            ->where('user_id', $id)
                            ->count();

            if ($checkChildID > 0) {
                Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
                return redirect()->back();
            }
        }

        if (!empty($kategori->path_foto)) {
            if( file_exists(public_path($kategori->path_foto)) ) {
                unlink(public_path($kategori->path_foto));
                $kategori->delete();
            } else {
                $kategori->delete();
            }
        } else {
            $kategori->delete();
        }

        toast('User berhasil dihapus.', 'success');
        return redirect()->back();
    }
}
