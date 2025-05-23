<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'name',
        'username',
        'email',
        'password',
        'role',
        'jabatan_id',
        'unit_id',
    ];

    public function jabatan(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'jabatan_id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function iku(){
        return $this->hasMany(IndikatorKinerjaUtama::class, 'iku_id', 'iku_id');
    }

    public function uploadIku(){
        return $this->hasMany(UploadIku::class, 'id', 'id');
    }

    public function uploadIki(){
        return $this->hasMany(Upload::class, 'id', 'id');
    }

    public function penilaianIku(){
        return $this->hasMany(PenilaianIku::class, 'id');
    }

    public function penilaianIki(){
        return $this->hasMany(PenilaianIki::class, 'id');
    }

    public function rekapPenilaian()
    {
        return $this->hasOne(RekapPenilaianIku::class, 'id', 'id'); // id pada tabel user = id pada tabel rekap_penilaian
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
