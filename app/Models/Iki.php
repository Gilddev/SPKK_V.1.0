<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iki extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_iki',
        'deskripsi_indikator', 
        'indikator_keberhasilan', 
        'parameter', 
        'unit_id', 
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function uploadIki(){
        return $this->hasMany(UploadIki::class);
    }

    public function penilaianIki(){
        return $this->hasOne(PenilaianIki::class);
    }
}
