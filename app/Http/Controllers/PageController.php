<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index', compact('pages'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'pindah_halaman' => 'required|string|max:255'
        ]);

        try {
            Page::create([
                'nama_page' => $request->nama_page,
                'deskripsi' => $request->deskripsi,
                'pindah_halaman' => $request->pindah_halaman,
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
            'pindah_halaman' => 'required|string|max:255'
        ]);

        $page = Page::findOrFail($id);
        $page->update($request->all());

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
        $page->delete();

        return redirect()->back()->with('success', 'Page deleted successfully.');
    }
}
