<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosis extends Model
{
    use HasFactory;
    protected $table = 'dosis';

    protected $fillable = [
        'dosis',
    ];

    public function vacunacion()
    {
        return $this->hasMany(Vacunacion::class, 'id');
    }
}
