<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\Background;
use App\Models\Ttd;
use App\Models\Rentang_Nilai;
use App\Models\User;
use App\Models\Event;
use App\Models\Event_Skema;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Instansi;
use Illuminate\Support\Facades\Auth;


class EventSkemaController extends Controller
{
    public function create($id) {
        $skema = Skema::get();
        $bg = Background::get();
        $ttd = Ttd::get();
        $rn = Rentang_Nilai::distinct()->pluck('nama_konversi_nilai');
        $penguji = User::where('level', 'Penguji')->get();
        return view('admin.event.create-skema', compact('skema', 'id' ,'bg', 'ttd', 'rn', 'penguji'));
    }

    public function store(Request $request, $idEvt) {

        $request->validate([
            'skema_id' => 'required | not_in:0',
            'ttd_id' => 'required',
            'user_id' => 'required',
            'background_id' => 'required | not_in:0',
            'nama_konversi_nilai' => 'required | not_in:0'
        ]);

        $createdBy = $request->input('created_by');
        $evt = Event::find($request->input('event_id'));
        $eventSkema = new Event_Skema($request->only([
            'skema_id',
            'background_id',
            'created_by'
        ]));

        $evt->eventEvent_Skema()->save($eventSkema);
        $id = $eventSkema->id_event_skema;
        $evtSkema = Event_Skema::find($id);
        $rn_id = Rentang_Nilai::where('nama_konversi_nilai', $request->input('nama_konversi_nilai'))
                                ->pluck('id_rentang_nilai');
        // // // $tgl_event = Event::where('id_event', $request->event_id)->pluck('tgl_mulai')->first();

        $evtSkema->event_skemaPenandatangan()->attach($request->input('ttd_id'), ['created_by' => $createdBy]);
        $evtSkema->event_skemaMenguji()->attach($request->input('user_id'), ['created_by' => $createdBy]);
        $evtSkema->event_skemaEvent_Skema_Rentang_Nilai()->attach($rn_id, ['created_by' => $createdBy]);
        
        return redirect()->route('event.rincian', $idEvt);
    }

    public function edit($evt, $id) {

        $evtSkema = Event_Skema::find($id);
        $ttd_id = $evtSkema->event_skemaPenandatangan()->pluck('ttd_id')->toArray(); //fix
        $penguji_id = $evtSkema->event_skemaMenguji()->pluck('user_id')->toArray();
        $rn_id = $evtSkema->event_skemaEvent_Skema_Rentang_Nilai()->distinct()
                          ->pluck('nama_konversi_nilai');

        $skema = Skema::get();
        $bg = Background::get();
        $ttd = Ttd::get();
        $rn = Rentang_Nilai::distinct()->pluck('nama_konversi_nilai');
        $penguji = User::where('level', 'Penguji')->get();

        return view('admin.event.edit-skema', compact('evt','evtSkema', 'skema', 'bg', 'ttd', 'rn', 'penguji', 'id', 'ttd_id', 'penguji_id', 'rn_id'));

    }

    public function update(Request $request, $evt, $id) {
        $evtSkema = Event_Skema::find($id);
        $updatedBy = $request->input('updated_by');

        $evtSkema->update([
            'skema_id' => $request->input('skema_id'),
            'background_id' => $request->input('background_id'),
            'updated_by' => $updatedBy
        ]);

        $rn_id = Rentang_Nilai::where('nama_konversi_nilai', $request->input('nama_konversi_nilai'))
                                ->pluck('id_rentang_nilai');
        $evtSkema->event_skemaPenandatangan()->syncWithPivotValues($request->input('ttd_id'), ['updated_by' => $updatedBy]);
        $evtSkema->event_skemaMenguji()->syncWithPivotValues($request->input('user_id'), ['updated_by' => $updatedBy]);
        $evtSkema->event_skemaEvent_Skema_Rentang_Nilai()->syncWithPivotValues($rn_id, ['updated_by' => $updatedBy]);

        return redirect()->route('event.rincian', $evt);
    }

    public function destroy($idEvent, $idSkema) {
        $evt = Event::find($idEvent);
        $evt->skema()->detach($idSkema);
        Alert::success('Berhasil!', 'Skema telah dihapus!');

        return redirect()->back();
    }

    public function show($evt, $id2) {
        $evtSkema = Event_Skema::find($id2);
        $ttd = $evtSkema->event_skemaPenandatangan()->pluck('nama_ttd');
        $penguji = $evtSkema->event_skemaMenguji()->pluck('nama_lengkap');
        $peserta = $evtSkema->event_skemaDaftar_Peserta()->get();
        $rn = $evtSkema->event_skemaEvent_Skema_Rentang_Nilai()->distinct()
                       ->pluck('nama_konversi_nilai');
        confirmDelete('Hapus Peserta', 'Apakah kamu yakin untuk menghapus?');

        return view('admin.event.rincian-skema', compact('evtSkema', 'ttd', 'rn', 'penguji', 'evt', 'peserta'));
    }

    // Peserta

    public function addStudent($evt, $skema) {
        $instansi = Instansi::get();
        return view('admin.event.add-student', compact('evt', 'skema', 'instansi'));
    }

    public function search($id) {
        $peserta = User::select('id_user', 'nama_lengkap', 'email', 'jenis_kelamin')->where('instansi_id', $id)->where('level', 'pengguna')->get();

        return response()->json($peserta);
    }

    public function storeStudents($event, $skema, Request $request) {

        // validasi
        $request->validate([
            'user_id' => 'required'
        ]);

        $evtSkema = Event_Skema::find($skema);
        $evtSkema->event_skemaDaftar_Peserta()->syncWithPivotValues($request
                 ->input('user_id'), ['created_by' => Auth::user()->id_user]);

        return redirect()->route('event-skema.show', [$event,$skema]);
    }

    public function destroyStudents($skema, $id) {
        $evtSkema = Event_Skema::find($skema);
        $evtSkema->event_skemaDaftar_Peserta()->detach($id);
        return back();
    }
}
