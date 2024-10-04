<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentang_Nilai extends Model
{
    use HasFactory;

    protected $table = "tb_rentang_nilai";
    protected $primaryKey = 'id_rentang_nilai';
    protected $guarded = ['id_rentang_nilai'];

    public function rentang_nilaiEvent_Skema_Rentang_Nilai() // PK Many-to-Many dengan tb_event_skema
    {
        return $this->belongsToMany(Event_Skema::class, 'tb_event_skema_rentang_nilai', 'rentang_nilai_id', 'event_skema_id');
    }

    public function rentangPage() // PK One-to-Many dengan tb_sub_skema
    {
        return $this->hasMany(Page::class, 'page_id', 'id_page');
    }
    // public function page()
    // {
    //     return $this->belongsTo(Page::class, 'page_id', 'id_page');
    // }
}
