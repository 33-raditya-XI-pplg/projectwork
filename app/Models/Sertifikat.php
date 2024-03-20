<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;
    protected $table = "tb_sertifikat";
    protected $primaryKey = 'id_sertifikat';
    protected $guarded = ['id_sertifikat'];

    public function sertifikatUser() // FK Many-to-One dengan tb_user
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    public function sertifikatEvent_Skema() // FK Many-to-One dengan tb_event_skema
    {
        return $this->belongsTo(Event_Skema::class, 'event_skema_id', 'id_event_skema');
    }
    public function sertifikatNilai_Sertifikat() // PK Many-to-Many dengan tb_nilai_peserta
    {
        return $this->belongsToMany(Nilai_Peserta::class, 'tb_nilai_sertifikat', 'sertifikat_id', 'nilai_id');
    }
}
