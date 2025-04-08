<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPenilaianIku extends Model
{
    use HasFactory;

    protected $table = 'rekap_penilaian';
    protected $fillable = [
        'id', 'total_iku', 'total_iki', 'jumlah_valid_iku', 'jumlah_valid_iki', 'persentase_valid_iku', 'persentase_valid_iki', 'persentase_kinerja'
    ];

    // protected $table = 'rekap_penilaian_ikus'; // Sesuaikan dengan nama tabel di database

    // protected $primaryKey = 'id'; // Sesuaikan jika primary key berbeda

    // public $timestamps = false; // Sesuaikan jika tabel tidak memiliki created_at dan updated_at

    // protected $fillable = [
    //     'id', 'total_iku', 'total_iki', 'jumlah_valid', 'persentase_valid'
    // ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id', 'id'); // Relasi ke tabel users berdasarkan id
    // }
}
