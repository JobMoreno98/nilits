<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class normatividadController extends Controller
{
    public function indexNo(){
        
        return view('normatividad.index');


    }
}
