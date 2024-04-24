<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Skema extends Model
{
    use HasFactory;
    protected $table = "tb_event_skema";
    protected $primaryKey = 'id_event_skema';
    protected $guarded = ['id_event_skema'];

    public function event_skemaSertifikat() // PK One-to-Many dengan tb_sertifikat
    {
        return $this->hasMany(Sertifikat::class, 'sertifikat_id', 'id_sertifikat');
    }
    public function event_skemaNilaiPeserta() // PK One-to-Many dengan tb_nilai_peserta
    {
        return $this->hasMany(Nilai_Peserta::class, 'nilai_peserta_id', 'id_nilai_peserta');
    }

    public function event_skemaEvent() // FK Many-to-One dengan tb_event
    {
        return $this->belongsTo(Event::class, 'event_id', 'id_event');
    }
    public function event_skemaSkema() // FK Many-to-One dengan tb_skema
    {
        return $this->belongsTo(Skema::class, 'skema_id', 'id_skema');
    }
    public function event_skemaBackground() // FK Many-to-One dengan tb_background
    {
        return $this->belongsTo(Background::class, 'background_id', 'id_background');
    }

    public function event_skemaDaftar_Peserta() // PK Many-to-Many dengan tb_user
    {
        return $this->belongsToMany(User::class, 'tb_peserta', 'event_skema_id', 'user_id');
    }
    public function event_skemaMenguji() // PK Many-to-Many dengan tb_user
    {
        return $this->belongsToMany(User::class, 'tb_menguji', 'event_skema_id', 'user_id');
    }
    public function event_skemaPenandatangan() // PK Many-to-Many dengan tb_penandatangan
    {
        return $this->belongsToMany(Ttd::class, 'tb_penandatangan', 'event_skema_id', 'ttd_id');
    }
    public function event_skemaEvent_Skema_Rentang_Nilai() // PK Many-to-Many dengan tb_rentang_nilai
    {
        return $this->belongsToMany(Rentang_Nilai::class, 'tb_event_skema_rentang_nilai', 'event_skema_id', 'rentang_nilai_id');
    }
}
