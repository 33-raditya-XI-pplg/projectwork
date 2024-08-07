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
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        Blog::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil disimpan.');

        return redirect()->back();
    }


    public function update(Request $request, $id) {
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'nullable|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $blog = Blog::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Delete old file if it exists
            if ($blog->photo && Storage::disk('public')->exists('photos/' . $blog->photo)) {
                Storage::disk('public')->delete('photos/' . $blog->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        $blog->update($data);

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
