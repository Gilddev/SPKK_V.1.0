<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periode_rekap',
        'total_iku', 
        'total_iki', 
        'jumlah_valid_iku', 
        'jumlah_valid_iki', 
        'persentase_valid_iku', 
        'persentase_valid_iki', 
        'persentase_kinerja'
    ];
}
