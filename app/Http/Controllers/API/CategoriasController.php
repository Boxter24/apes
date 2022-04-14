<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Categorias;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categorias::all();

        return response()->json($categorias);
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
     * @param  int  $id_categoria
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria = Categorias::create($request->post());

        return response()->json([
            'categoria' => $categoria,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categorias $categoria)
    {
        return response()->json($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id_categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  int  $id_categoria
     */
    public function update(Request $request, Categorias $categoria)
    {
        $categoria->update($request->all());

        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorias $categoria)
    {
        $categoria->delete();

        return response()->json([
            'mensaje' => "Categoria Eliminada",
        ]);
    }
}
