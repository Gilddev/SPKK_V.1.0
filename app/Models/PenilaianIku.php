<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIku extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'iku_id', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function iku()
    {
        return $this->belongsTo(Iku::class);
    }
}
