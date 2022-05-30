<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\model\Pasos;

class PasosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasos = Pasos::all();

        return response()->json($pasos);        
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
        $this->validate($request,[
            'nombre_paso' => 'required|string|max:30',
            'descripcion_paso' => 'required|string|max:150',                       
            'foto' => 'required',          
        ]);

        $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

        \Image::make($request->foto)->save(public_path('img/pasos/').$name);
        $request->merge(['foto' => $name]); 

        $paso = Pasos::create($request->post());

        return response()->json([
            'paso' => $paso,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($paso)
    {           
        $pasos = DB::table('pasos')
        ->where('id_guia','=',$paso)
        ->orderBy('orden_paso')
        ->get();
        
        return response()->json($pasos);                
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
    public function update(Request $request, Pasos $paso)
    {   
        $this->validate($request,[
            'nombre_paso' => 'required|string|max:30',
            'descripcion_paso' => 'required|string|max:150',
            'orden_paso' => 'required',
            'enlace_paso' => 'required',
            'foto' => 'required',            
        ]);

        //Verificar si la foto esta en base64
        if(strlen($request->foto)  > 20){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/pasos/').$name);
            $request->merge(['foto' => $name]); 
        }
        $paso->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pasos $paso)
    {
        $paso->delete();

        return response()->json([
            'mensaje' => "Paso Eliminado",
        ]);
    }
}
