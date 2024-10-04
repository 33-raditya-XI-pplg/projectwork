<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Skema extends Model
{
    use HasFactory;
    protected $table = "tb_sub_skema";
    protected $primaryKey = 'id_sub_skema';
    protected $guarded = ['id_sub_skema'];

    public function sub_skemaNilai_Peserta() // PK One-to-Many dengan tb_nilai_peserta
    {
        return $this->hasMany(Nilai_Peserta::class, 'nilai_peserta_id', 'id_nilai_peserta');
    }
    public function skema() // FK Many-to-One dengan tb_skema
    {
        return $this->belongsTo(Skema::class, 'skema_id', 'id_skema');
    }
}
