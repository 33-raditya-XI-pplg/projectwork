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
    public function index()
    {
        $page = Page::all();
        $blog = Blog::all();
        $kategori = Kategori::all();
        $Title = 'Management';
        $subtitle = 'Blog';
        return view('admin.blog.index', compact('page', 'blog', 'kategori', 'Title', 'subtitle'));
    }

    // $data = Blog::query();

    //     $page_id = $request->input('page_id');
    //     if (!empty($page_id)) {
    //         $data = $data->where('page_id',$page_id);
    //     }

    //     $data = $data->get()->map();





    public function store(Request $request)
    {

        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->all();


        $data['slug'] = Str::slug($request->input('judul'));


        $data['body'] = strip_tags($request->body);


        // if ($request->hasFile('photo')) {
        //     $file = $request->file('photo');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('public/photos', $filename);
        //     $data['photo'] = $filename;
        //     Storage::url($file);
        //     $data = $request->except(['photo']);
        //     $data['photo'] = "/storage/photos/$filename";
        // }

        if ($request->hasFile('photo')) {
            $foto = $request->file('photo');
            $filename = 'foto_' . time() . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/photos', $filename);
            Storage::url($storedPath);
            // $data = $request->except(['photo']);
            $data['photo'] = "/storage/photos/$filename";
        }

        // dd($data);
        $data['status'] = $request->has('status') ? $request->status : false;


        Blog::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil disimpan.');

        return redirect()->back();
    }





    public function update(Request $request, $id)
    {

        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'judul' => 'required|string|max:255',
            'body' => 'required|string',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $blog = Blog::findOrFail($id);

        $data = $request->all();


        $data['slug'] = Str::slug($request->input('judul'));


        $data['body'] = strip_tags($request->body);


        if ($request->hasFile('photo')) {
            if ($blog->path_foto) {
                $oldPhotoPath = str_replace('/storage', 'public', $blog->photo);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }
            $foto = $request->file('photo');
            $filename = 'foto_' . time() . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/photos', $filename);
            Storage::url($storedPath);
            $data = $request->except(['photo']);
            $data['photo'] = "/storage/photos/$filename";
        }


        $data['status'] = $request->has('status') ? $request->status : false;

        $blog->update($data);

        Alert::success('Berhasil Diperbarui!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }





    public function adminUpdate(Request $request, $id)
    {

        return $this->update($request, $id);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if ($blog) {
            $bannerPath = public_path($blog->path_banner);
            if (is_file($bannerPath) && unlink($bannerPath)) {
                Log::info("Successfully deleted file: " . $bannerPath);
            }

            $blog->delete();
            Alert::success('Success', 'Blog terhapus!');
        } else {
            Log::error("Blog not found with ID: " . $id);
            Alert::error('Error', 'Blog not found!');
        }

        return redirect()->back();
    }

    public function show($id)
    {
        // Mencari blog berdasarkan ID
        $blog = Blog::find($id);
        $Title = 'Management';
        $subtitle = 'Detail Blog';

        // Jika blog tidak ditemukan, redirect ke index dengan pesan error
        if (!$blog) {
            return redirect()->route('blog.index')->with('error', 'Blog tidak ditemukan.');
        }

        // Mengirim data blog ke tampilan
        return view('admin.blog.show', compact('blog', 'Title', 'subtitle'));
    }



}
