<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alumnos_model extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $primaryKey = 'codigo';
    protected $estatusPosibles = ['1' => 'Activo', '3' => 'Egresado', '4' => 'Baja'];

    public function getStatusAttribute()
    {
        return $this->estatusPosibles[$this->estatus];
    }
}
