<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_unit', 
        'nama_unit'
    ];

    public function users(){
        return $this->hasMany(User::class, 'unit_id');
    }

    public function iki(){
        return $this->hasMany(Iki::class, 'unit_id');
    }
}
