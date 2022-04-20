<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSintoma extends Model
{
    use HasFactory;
    protected $table = 'registroSintoma';

    public function persona(){
        return $this->belongsTo(Persona::class,'persona_id','id');
    }

    public function sintomasPersona(){
        return $this->hasMany(SintomaPersona::class,'id');
    }
}
