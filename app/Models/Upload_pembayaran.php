<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload_pembayaran extends Model
{
    use HasFactory;
    protected $table = "tb_upload_pembayaran";
    protected $primaryKey = 'id_upload_pembayaran';

    protected $fillable = [
        'event_skema_id',
        'user_id',
        'status_pembayaran',
        'bukti_pembayaran',
        'created_by',
        'updated_by',
    ];
    protected $attributes = [
        'status_pembayaran' => 'Belum Dibayar' // Default value
    ];
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id_event');
    }

}
