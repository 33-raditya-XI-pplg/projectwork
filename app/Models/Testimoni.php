<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'tb_testimoni';

    protected $primaryKey = 'id_testimoni';

    protected $fillable = [
        'page_id',
        'id_user',
        'email',
        'tanggal',
        'rating',
        'isi_testimoni',
        'photo',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'status_publikasi' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }

    // If you have a User model and created_by / updated_by reference to User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
