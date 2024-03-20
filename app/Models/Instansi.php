<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'tb_instansi';
    protected $primaryKey = 'id_instansi';
    protected $guarded = ['id_instansi'];

    public function instansiUser() // PK One-to-Many dengan tb_user
    {
        return $this->hasOne(User::class, 'user_id', 'id_user');
    }

    public function instansiEvent() // PK One-to-Many dengan tb_event
    {
        return $this->hasMany(Event::class, 'event_id', 'id_event');
    }
    public function instansiTtd() // PK One-to-Many dengan tb_ttd
    {
        return $this->hasMany(Ttd::class, 'ttd_id', 'id_ttd');
    }
}
