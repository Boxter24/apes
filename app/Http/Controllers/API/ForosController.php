<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Foros;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForosController extends Controller
{
    public function index()
    {                 
        $foros = DB::table('foros')
        ->where('estado','=','activo')
        ->leftJoin('users','foros.id_usuario','=','users.id')
        ->select('foros.id','nombre_foro','comentario_foro','fecha_publicacion','users.name')
        ->get();

        return $foros;
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
            'nombre_foro' => 'required|string|max:20',
            'comentario_foro' => 'required|string|max:30',                       
        ]);

        $id = Auth::id();
        $request->merge(['id_usuario' => $id]); 
        $foro = Foros::create($request->post());

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
        //dd($date);
        if($data == "forosDelDia"){
            $foros = DB::table('foros')
            ->where('fecha_publicacion','=',$date)            
            ->count();
        }   
        elseif($data == "hoy"){
            $foros = DB::table('foros')            
            ->where('estado','=','inactivo')            
            ->get();
        }   
        else{
            $foros = DB::table('foros')
            ->where('id','=',$data)
            ->select('comentario_foro')
            ->first();
        }         
        
        return response()->json($foros);
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
    public function update(Request $request, Foros $foro)
    {           
        $this->validate($request,[
            'nombre_foro' => 'required|string|max:20',
            'comentario_foro' => 'required|string|max:30',                       
        ]);
          
        $foro->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foros $foro)
    {
        $foro->delete();

        return response()->json([
            'mensaje' => "Foro Eliminada",
        ]);
    }
}
