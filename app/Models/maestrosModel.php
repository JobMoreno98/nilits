<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maestrosModel extends Model
{
    use HasFactory;
    protected $table = 'maestros';

    public function tutorados()
    {
        return $this->belongsToMany(alumnos_model::class, 'alumno_maestro', 'maestro_id',  'alumno_id')
        ->withPivot('activo')->wherePivot('activo', 1);
    }
}
