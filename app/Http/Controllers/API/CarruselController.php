<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Carrusel;

class CarruselController extends Controller
{
    public function index()
    {
        $carrusel = Carrusel::all();

        return response()->json($carrusel);
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
        $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

        \Image::make($request->foto)->save(public_path('img/carrusel/').$name);
        $request->merge(['foto' => $name]);        
                
        $carrusel = Carrusel::create($request->post());

        return response()->json([
            'carrusel' => $carrusel,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Carrusel $carrusel)
    {
        /*$facultad = DB::table('facultades')
        ->where('facultades.id','=',$facultade->id)
        ->leftJoin('carreras','carreras.id_facultad','=','facultades.id')
        ->get();
        return response()->json([
            'facultad' => $facultad,
        ]);*/
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
    public function update(Request $request, Carrusel $carrusel)
    {   
        //Verificar si la foto esta en base64
        if(strlen($request->foto)  > 20){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/carrusel/').$name);
            $request->merge(['foto' => $name]);  
        }      

        $carrusel->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carrusel $carrusel)
    {
        $carrusel->delete();

        return response()->json([
            'mensaje' => "Imagen Eliminada",
        ]);
    }
}
