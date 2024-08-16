<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Instansi;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{
    public function index() {
        $faq = Faq::all();
        $page = Page::get();

        confirmDelete('Hapus faq', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.faq.index', compact('faq','page'));
    }

    public function store(Request $request)
{
    // Validasi data request
    $request->validate([
        'page_id' => 'required|integer',
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'nullable|string',
        'status' => 'nullable|string', // Tambahkan validasi untuk status jika diperlukan
    ], [
        'page_id.required' => 'Page ID wajib diisi.',
        'page_id.integer' => 'Page ID harus berupa angka.',
        'pertanyaan.required' => 'Pertanyaan wajib diisi.',
        'pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
        'status.string' => 'Status harus berupa string.',
    ]);

    // Bersihkan tag <p> dari pertanyaan dan jawaban
    $cleanPertanyaan = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->pertanyaan);
    $cleanJawaban = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->jawaban);

    // Simpan data FAQ
    Faq::create([
        'page_id' => $request->page_id,
        'pertanyaan' => $cleanPertanyaan,
        'jawaban' => $cleanJawaban,
        'status' => $request->status, // Sertakan status
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
    ]);

    Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
    return redirect()->back();
}


public function update(Request $request, $id)
{
    // Validasi data request
    $request->validate([
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'nullable|string',
        'status' => 'nullable|string', // Tambahkan validasi untuk status
    ], [
        'pertanyaan.required' => 'Pertanyaan wajib diisi.',
        'pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
        'status.string' => 'Status harus berupa string.',
    ]);

    try {
        // Temukan FAQ berdasarkan ID
        $faq = Faq::findOrFail($id);

        // Bersihkan tag <p> dari pertanyaan dan jawaban
        $cleanPertanyaan = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->pertanyaan);
        $cleanJawaban = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->jawaban);

        // Perbarui data FAQ
        $faq->update([
            'pertanyaan' => $cleanPertanyaan,
            'jawaban' => $cleanJawaban,
            'status' => $request->status, // Sertakan status
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
        $faq = Faq::findOrFail($id);

        if ($faq->level == 'Faq') {
            $checkChildID = DB::table('tb_faq')
                            ->where('user_id', $id)
                            ->count();

            if ($checkChildID > 0) {
                Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
                return redirect()->back();
            }
        }

        if (!empty($faq->path_foto)) {
            if( file_exists(public_path($faq->path_foto)) ) {
                unlink(public_path($faq->path_foto));
                $faq->delete();
            } else {
                $faq->delete();
            }
        } else {
            $faq->delete();
        }

        toast('Faq berhasil dihapus.', 'success');
        return redirect()->back();
    }
}
