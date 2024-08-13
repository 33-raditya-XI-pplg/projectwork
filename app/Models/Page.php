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

    // One-to-many relationship with Partner
    public function partners()
    {
        return $this->hasMany(Partner::class, 'page_id', 'id_page');
    }

    public function pageGaleri()
    {
        return $this->hasMany(Galeri::class, 'page_id', 'id_page');
    }


    public function pageProfil() // PK one-to-many dengan tb_profil
    {
        return $this->hasMany(Profil_Perusahaan::class, 'page_id', 'id_profil_perusahaan');
    }

    public function pageFaq() // PK one-to-many dengan tb_faq
    {
        return $this->hasMany(Faq::class, 'page_id', 'id_faq');
    }

    public function pageBlog() // PK one-to-many dengan tb_blog
    {
        return $this->hasMany(Blog::class, 'page_id', 'id_page');
    }

    public function profilPerusahaan()
    {
        return $this->hasMany(Profil_Perusahaan::class, 'page_id', 'id_page');
    }


    public function sliders()
{
    return $this->hasMany(Slider::class, 'page_id', 'id_page');
}


public function testimoni()
{
    return $this->hasMany(Testimoni::class, 'page_id', 'id_page');
}

public function faqs()
{
    return $this->hasMany(Faq::class, 'page_id', 'id_page');
}



}
