<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class alumnos_model extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $primaryKey = 'id';
    protected $append = ['status'];

    protected $estatusPosibles = [
        '1' => '<b class="text-success">Activo</b>',
        '3' => '<b class="text-warning">Egresado</b>',
        '4' => '<b class="text-danger">Baja</b>',
    ];


    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->estatusPosibles[$this->estatus]
        );
    }

    public function getDictamenActualAttribute()
    {
        return explode(".", $this->dictamen)[0];
    }

    public function tutores()
    {
        return $this->belongsToMany(maestrosModel::class, 'alumno_maestro', 'alumno_id',  'maestro_id')->select('nombre', 'apellido')->withPivot('activo')->wherePivot('activo', 1);
    }
}
