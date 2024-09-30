<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\QueryException;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        $kategori = Kategori::orderBy('created_at', 'asc')->get();
        $Title = 'Management';
        $subtitle = 'Kategori';

        confirmDelete('Hapus kategori', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.kategori.index', compact('kategori', 'Title', 'subtitle'));
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);


        $cleanDeskripsi = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->deskripsi);

        try {

            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $cleanDeskripsi,
                'status' => $request->has('status') ? true : false,
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
        // Validasi request
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|boolean'
        ]);


        $cleanDeskripsi = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->deskripsi);

        try {

            $kategori = Kategori::findOrFail($id);


            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'deskripsi' => $cleanDeskripsi,
                'status' => $request->has('status') ? true : false,
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
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan.');
        }

        if ($kategori->blogs()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Kategori ini tidak dapat dihapus karena sedang digunakan di halaman Blog.');
        }

        try {
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('kategori.index')->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
