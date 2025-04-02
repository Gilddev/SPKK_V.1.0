<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorKinerjaUtama extends Model
{
    use HasFactory;
    protected $table = 'indikator_kinerja_utamas';

    protected $fillable = ['deskripsi_indikator', 'indikator_keberhasilan', 'parameter', 'id', 'iku_id'];

    protected $primaryKey = 'iku_id';

    public function validator()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function uploads(){
        return $this->hasMany(UploadIku::class, 'iku_id', 'iku_id');
    }

    public function penilaian(){
        return $this->hasOne(PenilaianIku::class, 'iku_id');
    }
}
