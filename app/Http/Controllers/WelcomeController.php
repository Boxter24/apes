<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(){

        $detalles = DB::table('detalles')
        ->first();
        //dd($footer);
        return view('welcome',compact('detalles'));
    }
}
