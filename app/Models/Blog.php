<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'tb_blog';
    protected $primaryKey = 'id_blog';

    protected $fillable = [
        'page_id',
        'kategori_id',
        'judul',
        'slug',
        'body',
        'photo',
        'status',
        'created_by',
        'updated_by',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }





}
