<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    protected $guarded = ['id_user'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Check users level 
    public function isLevel($level) {
        return $this->level === $level;
    }

    public function userInstansi() {  // FK one-to-one dengan tb_instansi
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id_instansi');
    }

    public function userLog() // PK one-to-many dengan tb_log
    {
        return $this->hasMany(Log::class, 'log_id', 'id_log');
    }
    public function userNilai_Peserta() {  // FK One-to-Many dengan tb_nilai_peserta
        return $this->hasMany(Nilai_Peserta::class, 'nilai_peserta_id', 'id_nilai_peserta');
    }
    public function userSertifikat() {  // FK One-to-Many dengan tb_sertifikat
        return $this->hasMany(Sertifikat::class, 'sertifikat_id', 'id_sertifikat');
    }

    public function userDaftar_Peserta() // PK many-to-many dengan tb_event_skema
    {
        return $this->belongsToMany(Event_Skema::class, 'tb_daftar_peserta','user_id', 'event_skema_id');
    }
    public function userMenguji() // PK many-to-many dengan tb_event_skema
    {
        return $this->belongsToMany(Event_Skema::class, 'tb_menguji','user_id', 'event_skema_id');
    }
}
