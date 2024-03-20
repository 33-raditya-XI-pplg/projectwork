<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempat extends Model
{
    use HasFactory;
    protected $table = "tb_tempat";
    protected $primaryKey = 'id_tempat';
    protected $guarded = ['id_tempat'];

    public function tempatEvent() // PK One-to-Many dengan tb_event
    {
        return $this->hasMany(Event::class, 'event_id', 'id_event');
    }
}
