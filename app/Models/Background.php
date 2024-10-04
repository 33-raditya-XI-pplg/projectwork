<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;
    protected $table = "tb_background";
    protected $primaryKey = 'id_background';
    protected $guarded = ['id_background'];

    public function backgroundEvent_Skema() // PK One-to-Many dengan tb_event_skema
    {
        return $this->hasMany(Event_Skema::class, 'event_skema_id', 'id_event_skema');
    }
    public function backgroundPage() // PK One-to-Many dengan tb_event_skema
    {
        return $this->hasMany(Page::class, 'page_id', 'id_page');
    }
    public function pageBackground()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
