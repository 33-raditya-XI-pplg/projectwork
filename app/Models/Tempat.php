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

    protected $fillable = [
        'page_id',
        'nama_tempat',
        'no_telp',
        'alamat',
        'alamat_kota',
        'link_maps',
        'created_by',
        'updated_by'
    ];

    public function tempatEvent() // PK One-to-Many dengan tb_event
    {
        return $this->hasMany(Event::class, 'event_id', 'id_event');
    }
    public function TempatPage() // PK One-to-Many dengan tb_sub_skema
    {
        return $this->hasMany(Page::class, 'page_id', 'id_page');
    }
    public function pageTempat()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
