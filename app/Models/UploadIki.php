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
        'user_id',
        'iki_id',
        'file_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function iki()
    {
        return $this->belongsTo(Iki::class, 'iki_id');
    }
}
