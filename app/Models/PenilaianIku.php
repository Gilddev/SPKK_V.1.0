<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIku extends Model
{
    use HasFactory;

    protected $table = 'penilaian_ikus';
    protected $fillable = ['id', 'iku_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorKinerjaUtama::class, 'iku_id', 'iku_id');
    }
}
