<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Kategori;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    public function index() {
        $page = Page::all();
        $blog = Blog::all(); // Eager load 'kategori' and 'page'
        $kategori = Kategori::all();
        return view('admin.blog.index', compact('page', 'blog', 'kategori'));
    }





    public function store(Request $request) {
        // Validate the request
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = $request->all();

        // Generate slug from title
        $data['slug'] = Str::slug($request->input('judul'));

        // Sanitize the 'body' field by stripping HTML tags
        $data['body'] = strip_tags($request->body);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        // Create blog entry
        Blog::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil disimpan.');

        return redirect()->back();
    }



    public function update(Request $request, $id) {
        // Validate the request
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $blog = Blog::findOrFail($id);

        $data = $request->all();

        // Generate slug from title
        $data['slug'] = Str::slug($request->input('judul'));

        // Sanitize the 'body' field by stripping HTML tags
        $data['body'] = strip_tags($request->body);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($blog->photo) {
                Storage::delete('public/photos/' . $blog->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        $blog->update($data);

        Alert::success('Berhasil Diperbarui!', 'Data berhasil diperbarui.');

        return redirect()->back();
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
