<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class alumnos_tutor extends Model
{
    use HasFactory;
    use Searchable;
    protected $table = 'alumnos_tutor';

    public function toSearchableArray()
    {
        return [
            'codigo' => $this->codigo,
            'Nombre' => $this->Nombre,
            'ingreso' => $this->ingreso,
            'estatus' => $this->estatus,
        ];
    }
}
