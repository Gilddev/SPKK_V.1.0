<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIKI extends Model
{
    use HasFactory;

    protected $table = 'penilaian_ikis';
    protected $fillable = ['id', 'indikator_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorKinerjaIndividu::class, 'indikator_id');
    }
}
