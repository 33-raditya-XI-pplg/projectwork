<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPerkembangan extends Model
{
    use HasFactory;

    protected $table = "tb_laporan_perkembangan";
    protected $primaryKey = 'id_laporan_perkembangan';
    protected $guarded = ['id']; // Guarded properties

    // Many-to-One relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    // Many-to-One relationship with SubSkema
    public function subSkema()
    {
        return $this->belongsTo(Sub_Skema::class, 'sub_skema_id', 'id_sub_skema');
    }

    // Many-to-One relationship with EventSkema
    public function eventSkema()
    {
        return $this->belongsTo(Event_Skema::class, 'event_skema_id', 'id_event_skema');
    }
    public function kemampuan() // PK One-to-Many dengan tb_sub_skema
    {
        return $this->hasMany(kemampuan_dasar::class, 'laporan_perkembangan_id');
    }

}
