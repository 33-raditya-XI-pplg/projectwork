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

class EventSkemaController extends Controller
{
    public function create($id) {
        $skema = Skema::get();
        $bg = Background::get();
        $ttd = Ttd::get();
        $rn = Rentang_Nilai::get();
        $penguji = User::where('level', 'Penguji')->get();
        return view('admin.event.create-skema', compact('skema', 'id' ,'bg', 'ttd', 'rn', 'penguji'));
    }

    public function store(Request $request) {

        $evt = Event::find($request->input('event_id'));
        $eventSkema = new Event_Skema($request->only([
            'skema_id',
            'background_id',
            'created_by'
        ]));

        $evt->eventEvent_Skema()->save($eventSkema);
        $id = $eventSkema->id_event_skema;
        // $tgl_event = Event::where('id_event', $request->event_id)->pluck('tgl_mulai')->first();

        $ttd = new Ttd();
        foreach ($request->input('ttd_id') as $ttd_id) {
            $ttd->ttdPenandatangan()->attach($id, [
                'ttd_id' => $ttd_id,
                'created_by' => $request->input('created_by')
            ]);
        }

        $penguji = new User();
        foreach ($request->input('user_id') as $userId) {
            $penguji->userMenguji()->attach($id, [
                'user_id' => $userId,
                // 'tgl_event' => $tgl_event,
                'created_by' => $request->input('created_by')
            ]);
        }
        return back();
    }

    public function edit($evt, $id) {

        $evtSkema = Event_Skema::find($id);
        $ttd_id = $evtSkema->event_skemaPenandatangan()->pluck('ttd_id')->toArray();
        $penguji_id = $evtSkema->event_skemaMenguji()->pluck('user_id')->toArray();
        $skema = Skema::get();
        $bg = Background::get();
        $ttd = Ttd::get();
        $rn = Rentang_Nilai::get();
        $penguji = User::where('level', 'Penguji')->get();
        return view('admin.event.edit-skema', compact('evt','evtSkema', 'skema', 'bg', 'ttd', 'rn', 'penguji', 'id', 'ttd_id', 'penguji_id'));

    }

    public function update(Request $request, $id) {
        $evtSkema = Event_Skema::find($id);
        $updatedBy = $request->input('updated_by');

        $evtSkema->update([
            'skema_id' => $request->input('skema_id'),
            'background_id' => $request->input('background_id'),
            'updated_by' => $updatedBy
        ]);

        $evtSkema->event_skemaPenandatangan()->syncWithPivotValues($request->input('ttd_id'), ['updated_by' => $updatedBy]);
        $evtSkema->event_skemaMenguji()->syncWithPivotValues($request->input('user_id'), ['updated_by' => $updatedBy]);

        return back();
    }

    public function destroy($idEvent, $idSkema) {
        $evt = Event::find($idEvent);
        $evt->skema()->detach($idSkema);
        Alert::success('Berhasil!', 'Skema telah dihapus!');

        return redirect()->back();
    }

    public function show($idEvent) {

        return view('admin.event.rincian-skema');
    }
}
