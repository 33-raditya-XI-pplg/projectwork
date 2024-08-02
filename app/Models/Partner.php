<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'tb_partner'; // Ensure this matches your actual table name
    protected $primaryKey = 'id_partner';
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'nama_partner',
        'email_partner',
        'telepon_partner',
        'alamat_partner',
        'jenis_partner',
        'tanggal_bergabung',
        'status_partner',
        'logo',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
        'status_partner' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id_page');
    }
}











