<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_Event extends Model
{
    use HasFactory;
    protected $table = "tb_jenis_event";
    protected $primaryKey = 'id_jenis_event';
    protected $guarded = ['id_jenis_event'];

    public function jenis_eventEvent_Skema() // PK One-to-Many dengan tb_event_skema
    {
        return $this->hasMany(Event_Skema::class, 'event_skema_id', 'id_event_skema');
    }
    public function jenisEvt_page() // PK One-to-Many dengan tb_event_skema
    {
        return $this->hasMany(Page::class, 'page_id', 'id_page');
    }
    public function pageJenisEvt()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
