<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = "tb_galeri";
    protected $primaryKey = 'id_galeri';
    protected $guarded = ['id_galeri'];

    public function galeriPage() // FK many-to-one dengan tb_page
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
