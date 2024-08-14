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
    $request->validate([
        'page_id'=> 'required|integer',
        'pertanyaan' => 'required|string|max:255',
        'jawaban' => 'nullable|string',
    ], [
        'page_id.required' => 'Page ID wajib diisi.',
        'page_id.integer' => 'Page ID harus berupa angka.',
        'pertanyaan.required' => 'Pertanyaan wajib diisi.',
        'pertanyaan.max' => 'Pertanyaan tidak boleh lebih dari 255 karakter.',
    ]);

    Faq::create([
        'page_id'=> $request->page_id,
        'pertanyaan' => $request->pertanyaan,
        'jawaban' => $request->jawaban,
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
    ]);

    Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
    return redirect()->back();
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'nullable|string',
        ]);

        try {
            $faq = Faq::findOrFail($id);
            $faq->update([
                'pertanyaan' => $request->pertanyaan,
                'jawaban' => $request->jawaban,
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
