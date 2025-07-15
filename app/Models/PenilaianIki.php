<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIki extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun', 
        'bulan', 
        'karyawan_id', 
        'validator_id',
        'iki_id', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function iki()
    {
        return $this->belongsTo(Iki::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
