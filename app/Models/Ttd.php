<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ttd extends Model
{
    use HasFactory;

    protected $table = "tb_ttd";
    protected $primaryKey = 'id_ttd';
    protected $guarded = ['id_ttd'];

    public function ttdInstansi() // FK Many-to-One dengan tb_instansi
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id_instansi');
    }

    public function ttdPenandatangan() // PK Many-to-Many dengan tb_event_skema
    {
        return $this->belongsToMany(Event_Skema::class, 'tb_penandatangan', 'ttd_id', 'event_skema_id');
    }
    public function ttdPage() // PK Many-to-Many dengan tb_event_skema
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
    public function pagettd()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
