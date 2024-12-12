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
        return dd($this->belongsToMany(alumnos_model::class, 'alumnos_maestros', 'id_maestro',  'id_alumno'));
    }
}
