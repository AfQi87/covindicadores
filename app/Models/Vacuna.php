<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;
    protected $table = 'vacuna';

    protected $fillable = [
        'vacuna',
    ];

    public function vacunacion()
    {
        return $this->hasMany(Vacunacion::class, 'id');
    }
}
