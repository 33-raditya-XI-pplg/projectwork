<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Jenis_Event;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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
        $checkChildID = Event::where('jenis_event_id', $id)->count();

        if ($checkChildID > 0) {
            Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
            return redirect()->back();
        }

        Jenis_Event::destroy($id);
        toast('Jenis Event Terhapus', 'success');
        return redirect()->back();
    }
}
