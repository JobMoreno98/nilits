<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alumnos_model extends Model
{
    use HasFactory;
    protected $table = 'alumnos';
    protected $primaryKey = 'codigo';

    // convertir los valores de estatus
    
    // public function getEstatusAttribute($value)
    // {
    //     switch ($value) {
    //         case 1:
    //             return 'Activo';
    //         case 3:
    //             return 'Egresado';
    //         case 4:
    //             return 'Baja';
    //         default:
    //             return 'otro';
    //     }
    // }
}


