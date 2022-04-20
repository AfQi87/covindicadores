<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sintoma extends Model
{
    use HasFactory;
    protected $table = 'sintoma';

    protected $fillable = [
        'nombre'
    ];
    public function sintomasPersona(){
        return $this->hasMany(SintomaPersona::class,'id');
    }
}
