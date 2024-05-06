<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alumno_tutorModel extends Model
{
    use HasFactory;
    protected $table = 'alumno_tutor';
    protected $fillable = [
        'id_tutor', // Identificador del tutor
        'codigo',   // Identificador (código) del alumno

    ];
    protected $attributes = [
        'Activo' => 1,
    ];
}
