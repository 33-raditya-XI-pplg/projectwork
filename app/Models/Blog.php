<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = "tb_blog";
    protected $primaryKey = 'id_blog';
    protected $guarded = ['id_blog'];

    public function blogPage() // FK many-to-one dengan tb_page
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
    public function blogBlog_Kategori() // PK Many-to-Many dengan tb_kategori
    {
        return $this->belongsToMany(Kategori::class, 'tb_blog_kategori', 'blog_id', 'kategori_id');
    }
}
