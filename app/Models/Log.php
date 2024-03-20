<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = "tb_log";
    protected $primaryKey = 'id_log';
    protected $guarded = ['id_log'];

    public function logUser() // FK Many-to-One dengan tb_user
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
