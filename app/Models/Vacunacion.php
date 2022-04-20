<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacunacion extends Model
{
    use HasFactory;
    protected $table = 'vacunacion';

    protected $fillable = [
        'fecha',
        'vacuna_id',
        'dosis_id',
        'persona_id'
    ];

    public function vacunas()
    {
        return $this->belongsTo(vacunas::class, 'vacuna_id', 'id');
    }

    public function dosis()
    {
        return $this->belongsTo(Dosis::class, 'dosis_id', 'id');
    }
}
