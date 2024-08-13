<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'tb_blog';  // Specifies the table name
    protected $primaryKey = 'id_blog';  // Specifies the primary key

    // Optionally use either $fillable or $guarded
    // protected $guarded = ['id_blog'];  // Uncomment if using guarded
    protected $fillable = [
        'page_id',
        'kategori_id',
        'judul',
        'slug',
        'body',
        'photo',
        'created_by',
        'updated_by',
    ];

    // Relationship to the Page model (Many-to-One)
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }

    // Relationship to the Kategori model (Many-to-Many)
    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'tb_blog_kategori', 'blog_id', 'kategori_id');
//         public function kategori()
// {
//     return $this->belongsToMany(Kategori::class, 'tb_blog_kategori', 'id_blog', 'id_kategori');
// }

    }


}
