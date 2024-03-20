<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    protected $table = "tb_profil";
    protected $primaryKey = 'id_profil';
    protected $guarded = ['id_profil'];

    public function profilPage() // FK many-to-one dengan tb_page
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}
