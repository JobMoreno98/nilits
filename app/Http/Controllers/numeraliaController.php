<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class numeraliaController extends Controller
{
    public function index()
{
    

    return view('numeralia.index');

   
}

}
