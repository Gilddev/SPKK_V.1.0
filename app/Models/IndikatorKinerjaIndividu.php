<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorKinerjaIndividu extends Model
{
    use HasFactory;
    protected $table = 'indikator_kinerja_individus';

    protected $fillable = ['deskripsi_indikator', 'indikator_keberhasilan', 'parameter', 'unit_id', 'id'];

    protected $primaryKey = 'indikator_id';


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function uploads(){
        return $this->hasMany(Upload::class, 'indikator_id', 'indikator_id');
    }

    public function penilaian(){
        return $this->hasOne(PenilaianIKI::class, 'indikator_id');
    }
}
