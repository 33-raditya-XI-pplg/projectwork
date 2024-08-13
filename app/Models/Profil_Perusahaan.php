<?php

namespace App\Models;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profil_Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'tb_profil_perusahaan';

    protected $primaryKey = 'id_profil_perusahaan';

    protected $fillable = [
        'page_id',
        'tentang_kami',
        'path_struktur_organisasi',
        'visi',
        'misi',
        'sejarah',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function blogPage() // FK many-to-one dengan tb_page
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }





}
