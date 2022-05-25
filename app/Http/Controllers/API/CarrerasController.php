<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\model\Carreras;

class CarrerasController extends Controller
{
    public function index()
    {           
        //$carreras = Carreras::all();
        $carreras = DB::table('carreras')
        ->leftjoin('facultades','carreras.id_facultad','=','facultades.id')
        ->select('carreras.id','nombre_carrera','descripcion_carrera',"carreras.foto",'id_facultad','nombre_facultad')
        ->get();

        return response()->json($carreras);
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
            'nombre_carrera' => 'required|string|max:12',
            'descripcion_carrera' => 'required|string|max:12',                                                                                                                                          
            'foto' => 'required',
        ]);

        $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

        \Image::make($request->foto)->save(public_path('img/carreras/').$name);
        $request->merge(['foto' => $name]);       
        
        $carrera = Carreras::create($request->post());

        return response()->json([
            'carrera' => $carrera,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($carrera)
    {
        $carreras = DB::table('carreras')
        ->where('id_facultad','=',$carrera)
        ->get();

        return response()->json($carreras);
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
    public function update(Request $request, Carreras $carrera)
    {   
        $this->validate($request,[
            'nombre_carrera' => 'required|string|max:12',
            'descripcion_carrera' => 'required|string|max:12',                                                                                                                                                      
        ]);

        //Verificar si la foto esta en base64
        if(strlen($request->foto)  > 20){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/carreras/').$name);
            $request->merge(['foto' => $name]);        
        }
        $carrera->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carreras $carrera)
    {
        $carrera->delete();

        return response()->json([
            'mensaje' => "Carrera Eliminada",
        ]);
    }
}
