<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Kategori;
use App\Models\BlogKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BlogKategoriController extends Controller
{
    public function index() {

        $blogkategori = BlogKategori::all();
        $blog = Blog::all();
        $kategori = Kategori::all();
        confirmDelete('Hapus BlogKategori', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.blog_kategori.index', compact('blogkategori','blog', 'kategori',));
    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'blog_id' => 'required|integer|exists:tb_blog,id_blog',
            'kategori_id' => 'required|integer|exists:tb_kategori,id_kategori'
        ]);


        $status = $request->has('status') ? $request->status : 'Draft';


        $validatedData['status'] = $status;
        $validatedData['created_by'] = Auth::user()->id_user;


        BlogKategori::create($validatedData);


        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }




    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'blog_id' => 'required|exists:tb_blog,id_blog',
            'kategori_id' => 'required|exists:tb_kategori,id_kategori'
        ]);


        $blogkategori = BlogKategori::findOrFail($id);


        Log::info('Update Request Data: ', $request->all());


        if ($request->hasFile('logo')) {

            if ($blogkategori->logo && Storage::disk('public')->exists($blogkategori->logo)) {
                Storage::disk('public')->delete($blogkategori->logo);
            }


            $logoPath = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $logoPath;
        }


        Log::info('Validated Data: ', $validatedData);
        Log::info('Current Blog Data: ', $blogkategori->toArray());


        $blogkategori->update($validatedData);


        Log::info('Updated blogkategori Data: ', $blogkategori->toArray());


        return redirect()->route('blogkategori.index')->with('success', 'blogkategori post updated successfully.');
    }

    public function destroy($id_blog_kategori) {

        $blogkategori = BlogKategori::find($id_blog_kategori);

        if ($blogkategori) {
            if (!empty($blogkategori->path_banner)) {

                $bannerPath = public_path($blogkategori->path_banner);

                if (is_file($bannerPath)) {
                    try {
                        if (unlink($bannerPath)) {
                            Log::info("Successfully deleted file: " . $bannerPath);
                        } else {
                            Log::error("Failed to delete file: " . $bannerPath);
                        }
                    } catch (\Exception $e) {
                        Log::error("Exception while deleting file: " . $bannerPath . " - " . $e->getMessage());
                    }
                } else {
                    Log::warning("Path is not a file or does not exist: " . $bannerPath);
                }
            } else {
                Log::warning("Path to banner file is empty.");
            }


            try {
                $blogkategori->delete();
                Alert::success('Berhasil', 'BlogKategori berhasil dihapus!');
            } catch (\Exception $e) {
                Log::error("Exception while deleting BlogKategori with ID: " . $id_blog_kategori . " - " . $e->getMessage());
                Alert::error('Gagal', 'BlogKategori gagal dihapus!');
            }
        } else {
            Log::error("BlogKategori not found with ID: " . $id_blog_kategori);
            Alert::error('Gagal', 'BlogKategori tidak ditemukan!');
        }

        return redirect()->back();
    }




}
