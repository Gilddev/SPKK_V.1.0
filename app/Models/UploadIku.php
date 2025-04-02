<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadIku extends Model
{
    use HasFactory;

    protected $table = 'upload_ikus';

    protected $fillable = ['id', 'iku_id', 'file_path'];

    protected $primaryKey = 'upload_iku_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'id','id');
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorKinerjaUtama::class, 'iku_id', 'iku_id');
    }

    public function indikator_utama()
    {
        return $this->belongsTo(IndikatorKinerjaUtama::class, 'iku_id');
    }
}
