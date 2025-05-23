<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $fillable = ['id', 'indikator_id', 'file_path', 'periode_penilaian'];

    protected $primaryKey = 'upload_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorKinerjaIndividu::class, 'indikator_id', 'indikator_id');
    }

    public function indikator_individu()
    {
        return $this->belongsTo(IndikatorKinerjaUtama::class, 'indikator_id');
    }
}
