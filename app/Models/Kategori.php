<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = "tb_kategori";
    protected $primaryKey = 'id_kategori';
    protected $guarded = ['id_kategori'];

    public function kategoriBlog_Kategori() // PK Many-to-Many dengan tb_blog
    {
        return $this->belongsToMany(Blog::class, 'tb_blog_kategori', 'kategori_id', 'blog_id');
    }
}
