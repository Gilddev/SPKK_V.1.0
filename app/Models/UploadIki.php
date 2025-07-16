<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadIki extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_penilaian',
        'unit_id',
        'karyawan_id',
        'iki_id',
        'file_path'
    ];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function iki()
    {
        return $this->belongsTo(Iki::class, 'iki_id');
    }
}
