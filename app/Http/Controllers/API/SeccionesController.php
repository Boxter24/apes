<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Secciones;
use Illuminate\Support\Facades\DB;

class SeccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $secciones = DB::table('secciones')
        ->leftjoin('carreras','secciones.id_carrera','=','carreras.id')
        ->leftjoin('categorias','secciones.id_categoria','=','categorias.id')
        ->select('secciones.id','nombre_seccion','descripcion_seccion',"secciones.foto",'id_carrera','nombre_carrera','id_categoria','nombre_categoria')
        ->get();

        return response()->json($secciones);        
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
            'nombre_seccion' => 'required|string|max:20',
            'descripcion_seccion' => 'required|string|max:150',
            'id_carrera' => 'required',
            'id_categoria' => 'required',
            'foto' => 'required',            
        ]);

        $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

        \Image::make($request->foto)->save(public_path('img/secciones/').$name);
        $request->merge(['foto' => $name]); 

        $seccion = Secciones::create($request->post());

        return response()->json([
            'seccion' => $seccion,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($seccione)
    {   
        $carrera = substr($seccione, 0, 1);

        $categoria = substr($seccione, 1, 2);;

        $secciones = DB::table('secciones')
        ->where('id_carrera','=',$carrera)
        ->where('id_categoria','=',$categoria)
        ->get();
        return response()->json($secciones);                
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
    public function update(Request $request, Secciones $seccione)
    {   
        $this->validate($request,[
            'nombre_seccion' => 'required|string|max:20',
            'descripcion_seccion' => 'required|string|max:150',
            'id_carrera' => 'required',
            'id_categoria' => 'required',
            'foto' => 'required',            
        ]);

        //Verificar si la foto esta en base64
        if(strlen($request->foto)  > 20){
            $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];

            \Image::make($request->foto)->save(public_path('img/secciones/').$name);
            $request->merge(['foto' => $name]); 
        }
        $seccione->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Secciones $seccione)
    {
        $seccione->delete();

        return response()->json([
            'mensaje' => "Seccion Eliminada",
        ]);
    }
}



