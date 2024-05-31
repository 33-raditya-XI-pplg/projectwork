<?php

namespace App\Http\Controllers;

use App\Models\Event_Skema;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Background;
use Illuminate\Support\Facades\Storage;

class BackgroundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bg = Background::get();

        confirmDelete('Hapus Background', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.background.index', compact('bg'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bg = $request->file('bg');
        $filename = 'bg_' .$request->nama_bg . '.' .$bg->getClientOriginalExtension();
        $stored = $bg->storeAs('public/background', $filename);

        $request->merge([
            'path_bg' => Storage::url($stored)
        ]);

        Background::create($request->all());
        Alert::success('Berhasil Tersimpan!', 'Background berhasil ditambahkan');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if ($request->has('bg')) {
            $bg = $request->file('bg');
            $filename = 'bg_' .$request->nama_bg . '.' .$bg->getClientOriginalExtension();
            unlink(public_path(Background::find($id)->path_bg));

            $stored = $bg->storeAs('public/background', $filename);

            $request->merge([
                'path_bg' => Storage::url($stored)
            ]);

        }

        Background::find($id)->update($request->all());
        Alert::success('Berhasil Tersimpan!', 'Background berhasil diedit.');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bg = Background::find($id)->path_bg;

        $checkChildID = Event_Skema::where('background_id', $id)->count();

        if ($checkChildID > 0) {
            Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
            return redirect()->back();
        }

        if (!empty($bg)) {
            if( file_exists(public_path($bg)) ) {
                unlink(public_path($bg));
                Background::destroy($id);
            } else {
                Background::destroy($id);
            }
        } else {
            Background::destroy($id);
        }

        toast('Background terhapus!','success');
        return redirect()->back();
    }
}
