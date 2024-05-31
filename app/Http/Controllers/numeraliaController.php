<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\alumno_tutorModel;
use App\Models\alumnos_model;

class numeraliaController extends Controller
{
    public function index()
    {



        return view('numeralia.index');
    }
}
