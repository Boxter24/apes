<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Foros;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForosController extends Controller
{
    public function index()
    {                 
        return Foros::all();
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
    public function show($usuario)
    {
        $foros = DB::table('foros')
        ->where('id_usuario','=',$usuario)
        ->get();

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
