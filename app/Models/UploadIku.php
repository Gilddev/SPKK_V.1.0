<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadIku extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_penilaian',
        'karyawan_id',
        'iku_id', 
        'file_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function iku()
    {
        return $this->belongsTo(Iku::class, 'iku_id');
    }
}
