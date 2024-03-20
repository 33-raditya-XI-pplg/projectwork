<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = "tb_page";
    protected $primaryKey = 'id_page';
    protected $guarded = ['id_page'];

    public function pageGaleri() // PK one-to-many dengan tb_galeri
    {
        return $this->hasMany(Galeri::class, 'galeri_id', 'id_galeri');
    }
    public function pageProfil() // PK one-to-many dengan tb_profil
    {
        return $this->hasMany(Profil::class, 'profil_id', 'id_profil');
    }
    public function pageFaq() // PK one-to-many dengan tb_faq
    {
        return $this->hasMany(Faq::class, 'faq_id', 'id_faq');
    }
    public function pageBlog() // PK one-to-many dengan tb_blog
    {
        return $this->hasMany(Blog::class, 'blog_id', 'id_blog');
    }
}
