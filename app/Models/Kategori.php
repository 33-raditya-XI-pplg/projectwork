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
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'kategori_id', 'id_kategori');
    }



}
