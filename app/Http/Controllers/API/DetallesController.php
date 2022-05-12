<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\model\Detalles;

class DetallesController extends Controller
{
    public function index()
    {           
        //return Detalles::all();
        $detalles = DB::table('detalles')
        ->first();        

        return response()->json($detalles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = time().'.' . explode('/', explode(':', substr($request->logo_institucion, 0, strpos($request->logo_institucion, ';')))[1])[1];

        \Image::make($request->logo_institucion)->save(public_path('img/detalles/').$name);
        $request->merge(['logo_institucion' => $name]);       
        
        $detalle = Detalles::create($request->post());

        return response()->json([
            'detalle' => $detalle,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($detalle)
    {
        $detalles = Detalles::all();

        return response()->json($detalles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id
     */
    public function update(Request $request, Detalles $detalle)
    {   
        if(strlen($request->logo_institucion)  > 20){
            $name = time().'.' . explode('/', explode(':', substr($request->logo_institucion, 0, strpos($request->logo_institucion, ';')))[1])[1];

            \Image::make($request->logo_institucion)->save(public_path('img/detalles/').$name);
            $request->merge(['logo_institucion' => $name]);
        }                
            
        $detalle->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detalles $detalle)
    {
        $detalle->delete();

        return response()->json([
            'mensaje' => "Detalle Eliminado",
        ]);
    }
}
