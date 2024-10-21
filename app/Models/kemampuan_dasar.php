<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kemampuan_dasar extends Model
{
    use HasFactory;

    protected $table = "tb_kemampuan_dasar";
    protected $primaryKey = 'id_kemampuan_dasar';
    protected $guarded = ['id_kemampuan_dasar'];

    public function Laporan() // FK Many-to-One dengan tb_skema
    {
        return $this->belongsTo(LaporanPerkembangan::class, 'laporan_perkembangan_id', 'id_laporan_perkembangan');
    }
}
