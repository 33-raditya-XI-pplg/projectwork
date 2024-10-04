<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    use HasFactory;
    protected $table = "tb_skema";
    protected $primaryKey = 'id_skema';
    protected $guarded = ['id_skema'];

    public function skemaEvent_Skema() // PK One-to-Many dengan tb_event_skema
    {
        return $this->hasMany(Event_Skema::class, 'event_skema_id', 'id_event_skema');
    }
    public function skemaSub_Skema() // PK One-to-Many dengan tb_sub_skema
    {
        return $this->hasMany(Sub_Skema::class, 'skema_id');
    }
    public function skemaPage() // PK One-to-Many dengan tb_sub_skema
    {
        return $this->hasMany(Page::class, 'page_id', 'id_page');
    }
    public function pageskema()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
