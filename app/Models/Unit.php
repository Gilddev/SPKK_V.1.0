<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    protected $primaryKey = 'unit_id';
    protected $fillable = ['nama_unit'];

    public function users(){
        return $this->hasMany(User::class, 'unit_id', 'unit_id');
    }
}
