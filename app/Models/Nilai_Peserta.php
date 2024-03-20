<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai_Peserta extends Model
{
    use HasFactory;
    protected $table = "tb_nilai_peserta";
    protected $primaryKey = 'id_nilai_peserta';
    protected $guarded = ['id_nilai_peserta'];

    public function nilai_pesertaUser() // FK Many-to-One dengan tb_user
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    public function nilai_pesertaSub_Skema() // FK Many-to-One dengan tb_sub_skema
    {
        return $this->belongsTo(Sub_Skema::class, 'sub_skema_id', 'id_sub_skema');
    }
    public function nilai_pesertaEvent_Skema() // FK Many-to-One dengan tb_event_skema
    {
        return $this->belongsTo(Event_Skema::class, 'event_skema_id', 'id_event_skema');
    }

    public function nilai_pesertaNilai_Sertifikat() // PK Many-to-Many dengan tb_sertifikat
    {
        return $this->belongsToMany(Sertifikat::class, 'tb_nilai_sertifikat', 'nilai_id', 'sertifikat_id');
    }
}
