<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_iku', 
        'deskripsi_indikator', 
        'indikator_keberhasilan', 
        'parameter', 
        'berulang'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function uploadsIku(){
        return $this->hasMany(UploadIku::class);
    }

    public function penilaianIku(){
        return $this->hasOne(PenilaianIku::class);
    }
}
