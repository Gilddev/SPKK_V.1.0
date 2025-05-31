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
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function iku(){
        return $this->hasMany(Iku::class);
    
    }
    public function iki(){
        return $this->hasMany(Iki::class);
    }

    public function uploadIku(){
        return $this->hasMany(UploadIku::class);
    }

    public function uploadIki(){
        return $this->hasMany(UploadIki::class);
    }

    public function penilaianIku(){
        return $this->hasMany(PenilaianIku::class);
    }

    public function penilaianIki(){
        return $this->hasMany(PenilaianIki::class);
    }

    public function rekapPenilaian()
    {
        return $this->hasOne(RekapPenilaian::class); // id pada tabel user = id pada tabel rekap_penilaian
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
