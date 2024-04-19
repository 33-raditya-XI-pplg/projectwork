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

class EventSkema extends Controller
{
    public function create() {
        $skema = Skema::get();
        $bg = Background::get();
        $ttd = Ttd::get();
        $rn = Rentang_Nilai::get();
        $penguji = User::where('level', 'Penguji')->get();
        return view('admin.event.create-skema', compact('skema', 'bg', 'ttd', 'rn', 'penguji'));
    }

    public function store(Request $request) {

        $evt = Event::find($request->input('event_id'));
        dd($request->event_id);
        $eventSkema = new Event_Skema($request->only([
            'skema_id',
            'background_id',
            'created_by'
        ]));
        $evt->eventEvent_Skema()->save($eventSkema);

        // $eventSkema = Event_Skema::create($request->only([
        //     'event_id', 'skema_id', 'background_id', 'created_by'
        // ]));

        $id = $eventSkema->id_event_skema;
        $tgl_event = Event::where('id_event', $request->event_id)->pluck('tgl_mulai')->first();

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
                'tgl_event' => $tgl_event,
                'created_by' => $request->input('created_by')
            ]);
        }



        return view('dashboard');
    }

    public function delete(Request $request) {
        dd($request->event_id);
        // $evt_skema = Event::find($id);
        // $evt_skema->event_skemaSkema()
    }

    public function show($id) {

        return view('admin.event.rincian-skema');
    }
}
