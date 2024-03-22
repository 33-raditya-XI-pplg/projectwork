<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Jenis_Event;

class JenisEventController extends Controller
{
    public function index() {
        $jenis_event = Jenis_Event::get();
        confirmDelete('Hapus Jenis Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.jenis-evt.index', compact('jenis_event'));
    }

    public function store(Request $request) {
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }

        Jenis_Event::create($request->all());
        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        
        return redirect()->back();
    }

    public function update(Request $request, $id) {
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }

        $jenis_event = Jenis_Event::find($id);
        $jenis_event->update($request->all());
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        
        return redirect()->back();
    }

    public function destroy($id) {
        Jenis_Event::destroy($id);
        toast('Jenis Event Terhapus', 'success');
        return redirect()->back();
    }
}
