<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Informaciones;
use Illuminate\Support\Facades\DB;

class InformacionesController extends Controller
{
    public function index()
    {
        $informaciones = Informaciones::all();

        return response()->json($informaciones);
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
            'nombre_informacion' => 'required|string|max:20',
            'descripcion_informacion' => 'required|string|max:30',            
            'foto' => 'required',            
        ]);

        if(isset($request->foto)){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/informaciones/').$name);
            $request->merge(['foto' => $name]);     
        }                           
                
        $informacion = Informaciones::create($request->post());

        return response()->json([
            'informacion' => $informacion,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Informaciones $informacione)
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
    public function update(Request $request, Informaciones $informacione)
    {   
        $this->validate($request,[
            'nombre_informacion' => 'required|string|max:50',
            'descripcion_informacion' => 'required|string|max:250',            
            'foto' => 'required',            
        ]);
        
        //Verificar si la foto esta en base64
        if(strlen($request->foto)  > 20){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/informaciones/').$name);
            $request->merge(['foto' => $name]);      
        }  

        $informacione->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Informaciones $informacione)
    {
        $informacione->delete();

        return response()->json([
            'mensaje' => "Información Eliminada",
        ]);
    }
}
