<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';
    protected $primaryKey = 'jabatan_id';
    protected $fillable = ['nama_jabatan'];

    public function users(){
        return $this->hasMany(User::class, 'jabatan_id', 'jabatan_id');
    }
}
