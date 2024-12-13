<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alumnos_model extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $primaryKey = 'id';

    protected $estatusPosibles = ['1' => 'Activo', '3' => 'Egresado', '4' => 'Baja'];

    public function getStatusAttribute()
    {
        return $this->estatusPosibles[$this->estatus];
    }

    public function getDictamenActualAttribute()
    {
        return explode(".",$this->dictamen)[0];
    }

    public function tutores()
    {
        return $this->belongsToMany(maestrosModel::class, 'alumno_maestro', 'alumno_id',  'maestro_id')->select('nombre','apellido')->withPivot('activo')->wherePivot('activo', 1);
    }
}
