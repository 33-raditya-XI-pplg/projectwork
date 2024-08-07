<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    public function index() {
        $page = Page::all();
        $blog = Blog::all();
        return view('admin.blog.index', compact('page', 'blog'));
    }

    public function store(Request $request) {
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required|string',
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $path = $request->file('logo')->store('public/banner-blog');
        $request->merge(['path_banner' => Storage::url($path)]);

        Blog::create($request->all());
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($blog->logo && Storage::disk('public')->exists($blog->logo)) {
                Storage::disk('public')->delete($blog->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $blog->update($validatedData);

        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function adminUpdate(Request $request, $id) {
        // Logika yang sama dengan update
        return $this->update($request, $id);
    }

    public function destroy($id) {
        $blog = Blog::find($id);

        if ($blog) {
            $bannerPath = public_path($blog->path_banner);
            if (is_file($bannerPath) && unlink($bannerPath)) {
                Log::info("Successfully deleted file: " . $bannerPath);
            }

            $blog->delete();
            toast('Blog terhapus!', 'success');
        } else {
            Log::error("Blog not found with ID: " . $id);
            toast('Blog not found!', 'error');
        }

        return redirect()->back();
    }

    public function show($id) {
        $blog = Blog::find($id);

        if (!$blog) {
            // Jika blog tidak ditemukan, redirect ke halaman sebelumnya dengan pesan error
            return redirect()->route('blog.index')->with('error', 'Blog not found.');
        }

        return view('admin.blog.show', compact('blog'));
    }


}
