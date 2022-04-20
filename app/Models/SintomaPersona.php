<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SintomaPersona extends Model
{
    use HasFactory;
    protected $table = 'sintomaPersona';

    public function sintomas(){
        return $this->belongsTo(Sintoma::class,'sintoma_id','id');
    }

    public function regSintomas(){
        return $this->belongsTo(RegistroSintoma::class,'registroSintoma_id','id');
    }
}
