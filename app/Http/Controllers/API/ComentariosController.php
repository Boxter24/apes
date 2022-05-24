<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Comentarios;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComentariosController extends Controller
{
    public function index()
    {                 
        $comentarios = DB::table('comentarios')
        ->leftJoin('users','comentarios.id_usuario','=','users.id')
        ->leftJoin('foros','comentarios.id_foro','=','foros.id')
        ->select('comentarios.id','comentario','fecha_comentario','users.name','users.foto','nombre_foro','comentario_foro')
        ->get();

        return $comentarios;
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
            'comentario' => 'required|string|max:200',                                                                     
        ]);

        $id = Auth::id();
        $request->merge(['id_usuario' => $id]); 

        $date = Carbon::now()->format('Y-m-d');
        $request->merge(['fecha_comentario' => $date]); 
        
        $foro = Comentarios::create($request->post());

        return response()->json([
            'Success' => $id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($data)
    {   
        $date = Carbon::now()->format('Y-m-d'); 

        if($data == "comentariosDelDia"){
            $comentarios = DB::table('comentarios')
            ->where('fecha_comentario','=',$date)            
            ->count();
        }   
        elseif($data == "hoy"){
            $comentarios = DB::table('comentarios')            
            ->where('comentarios.estado','=','inactivo')   
            ->leftJoin('users','comentarios.id_usuario','=','users.id')
            ->leftJoin('foros','comentarios.id_foro','=','foros.id')
            ->select('comentarios.id','comentario','fecha_comentario','users.name','users.foto','nombre_foro','comentario_foro')         
            ->get();
        }
        else{
            $comentarios = DB::table('comentarios')
            ->where('id_foro','=',$data)
            ->leftJoin('users','comentarios.id_usuario','=','users.id')
            ->leftJoin('foros','comentarios.id_foro','=','foros.id')
            ->select('comentarios.id','comentario','fecha_comentario','users.name','users.foto','nombre_foro','comentario_foro')
            ->get();
        }
        
        return $comentarios;    
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
    public function update(Request $request, Comentarios $comentario)
    {           
        $this->validate($request,[
            'comentario' => 'required|string|max:250',                                                                     
        ]);
        
        $comentario->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentarios $comentario)
    {
        $comentario->delete();

        return response()->json([
            'mensaje' => "Comentario Eliminado",
        ]);
    }
}
