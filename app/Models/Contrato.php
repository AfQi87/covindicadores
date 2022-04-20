<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $table = 'contrato';

    protected $fillable = [
        'fecha_ini',
        'fecha_fin',
        'descripcion',
        'empleado_id',
    ];
}
