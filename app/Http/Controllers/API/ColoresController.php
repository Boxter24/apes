<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Colores;
use Illuminate\Support\Facades\DB;

class ColoresController extends Controller
{
    public function index()
    {           
        //return Detalles::all();
        $detalles = DB::table('colores')
        ->first();        

        return response()->json($detalles);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function update(Request $request, Colores $colore)
    {                           
        $colore->update($request->all());

        return ['message' => "Success"];
    }    
}
