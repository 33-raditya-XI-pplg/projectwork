<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Page;

class GaleriController extends Controller
{

    public function index()
    {
        $pages = Page::all();
        $galeri = Galeri::all();
        $Title = 'Management';
        $subtitle = 'Galeri';

        return view('admin.galeri.index', compact('galeri', 'pages', 'Title', 'subtitle'));
    }



    public function create()
    {

        $pages = Galeri::table('tb_page')->get();


        return view('admin.galeri.create', compact('pages'));
    }




    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'page_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'path_file' => 'required|file|mimes:jpg,jpeg,png,bmp|max:2048',
            'kategori' => 'required|in:partner,klien,gambar,video',
            'deskripsi' => 'nullable|string',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);


        if ($request->hasFile('path_file')) {
            $file = $request->file('path_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $filename;
            $file->move(public_path('images'), $filename);
            $validatedData['path_file'] = '/images/' . $filename;
        }


        $validatedData['created_by'] = auth()->user() ? auth()->user()->id : null;
        $validatedData['updated_by'] = auth()->user() ? auth()->user()->id : null;


        Galeri::create($validatedData);


        $validatedData = Galeri::all();


        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dibuat.');
    }




    public function show(Galeri $galeri)
    {
        return view('galeri.show', compact('galeri'));
    }


    public function edit($id)
    {

        $galeri = Galeri::findOrFail($id);


        return view('admin.galeri.edit', compact('galeri'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([

            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,svg,webp|max:10240',
            'description' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
        ]);


        $galeri = Galeri::findOrFail($id);


        $galeri->deskripsi = $request->input('description');
        $galeri->kategori = $request->input('kategori');


        if ($request->hasFile('image')) {

            if (file_exists(public_path($galeri->path_file))) {
                unlink(public_path($galeri->path_file));
            }


            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);


            $galeri->path_file = '/images/' . $imageName;
        }


        $galeri->save();


        return redirect()->route('galeri.index')->with('success', 'Gambar berhasil diperbarui.');
    }



    public function destroy($id)
    {

        $galeri = Galeri::findOrFail($id);


        if (file_exists(public_path($galeri->path_file))) {
            unlink(public_path($galeri->path_file));
        }


        $galeri->delete();


        return redirect()->route('galeri.index')->with('success', 'Gambar berhasil dihapus.');
    }



}
