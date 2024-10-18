<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = "tb_event";
    protected $primaryKey = 'id_event';
    protected $guarded = ['id_event'];

    protected $fillable = [
        'instansi_id',
        'tempat_id',
        'jenis_event_id',
        'page_id', // Make sure this is included
        'nama_event',
        'tgl_mulai',
        'tgl_berakhir',
        'biaya_regis',
        'path_banner',
        'deskripsi',
        'status',
        'visibilitas',
        'updated_by'
    ];

    public function eventEvent_Skema() // PK One-to-Many dengan tb_event_skema
    {
        // return $this->hasMany(Event_Skema::class, 'event_skema_id', 'id_event_skema');
        return $this->hasMany(Event_Skema::class, 'event_id');
    }
    public function eventInstansi() // FK Many-to-One dengan tb_instansi
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id_instansi');
    }
    public function eventTempat() // FK Many-to-One dengan tb_tempat
    {
        return $this->belongsTo(Tempat::class, 'tempat_id');
    }
    public function eventJenis_Event() // FK Many-to-One dengan tb_jenis_event
    {
        return $this->belongsTo(Jenis_Event::class, 'jenis_event_id', 'id_jenis_event');
    }
    public function eventPage()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }

    public function skema()
    {
        return $this->belongsToMany(Event_Skema::class, 'tb_event_skema', 'event_id', 'skema_id');
    }

    public function uploadPembayaran()
    {
        return $this->hasMany(Upload_pembayaran::class, 'event_id', 'id_event');
    }
}
