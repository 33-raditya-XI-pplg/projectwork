<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'tb_slider'; // Nama tabel

    protected $primaryKey = 'id_slider'; // Primary key

    protected $fillable = [
        'page_id',
        'title',
        'description',
        'image_url',
        'position',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the page that owns the slider.
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
