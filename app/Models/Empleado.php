<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';
    protected $fillable = [
        'titulo',
        'cargo_id',
        'persona_id',
        'nivelEd_id',
        'estado_id',
    ];
}
