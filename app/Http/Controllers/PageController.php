<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::all();
        $Title = 'Management';
        $subtitle = 'Page';
        return view('admin.page.index', compact('pages', 'Title', 'subtitle'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string|max:255',
            'status' => 'nullable|boolean'
        ]);

        try {

            $sanitizedDeskripsi = strip_tags($request->deskripsi);


            Page::create([
                'nama_page' => $request->nama_page,
                'deskripsi' => $sanitizedDeskripsi,
                'pindah_halaman' => $request->pindah_halaman,
                'status' => $request->has('status') ? true : false,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return Redirect::route('page.index')->with('success', 'Page created successfully.');
        } catch (\Exception $e) {
            return Redirect::route('page.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string|max:255',
            'status' => 'nullable|boolean'
        ]);

        $page = Page::findOrFail($id);
        $page->update([
            'nama_page' => $request->nama_page,
            'deskripsi' => strip_tags($request->deskripsi),
            'pindah_halaman' => $request->pindah_halaman,
            'status' => $request->has('status') ? true : false,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('page.index')->with('success', 'Page updated successfully.');
    }



    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.page.edit', compact('page'));
    }




    public function destroy($id)
    {
        $page = Page::findOrFail($id);


        $messages = [];


        if ($page->partners()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Partner.';
        }
        if ($page->pageGaleri()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Galeri.';
        }
        if ($page->pageProfil()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Profil.';
        }
        if ($page->pageFaq()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman FAQ.';
        }
        if ($page->pageBlog()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Blog.';
        }
        if ($page->profilPerusahaan()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Profil Perusahaan.';
        }

        if ($page->sliders()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Slider.';
        }

        if ($page->testimoni()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman Testimoni.';
        }

        if ($page->faqs()->exists()) {
            $messages[] = 'Page ini masih digunakan di halaman FAQ.';
        }


        if (!empty($messages)) {
            $errorMessage = implode(' ', $messages);
            return redirect()->back()->with('error', $errorMessage);
        }


        if ($page->pageGaleri()->exists()) {

            $page->pageGaleri()->delete();
        }


        if ($page->profilPerusahaan()->exists()) {

            $page->profilPerusahaan()->delete();
        }

        if ($page->sliders()->exists()) {

            $page->sliders()->delete();
        }

        if ($page->testimoni()->exists()) {

            $page->testimoni()->delete();
        }

        if ($page->faqs()->exists()) {
            $page->faqs()->delete();
        }


        $page->delete();

        return redirect()->back()->with('success', 'Page berhasil dihapus.');
    }


    public function show($id)
    {
        $page = page::findOrFail($id);
        $Title = 'Management';
        $subtitle = 'Detail Page';
        return view('admin.page.show', compact('page', 'Title', 'subtitle'));
    }
}
