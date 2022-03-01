<?php

namespace App\Http\Controllers;

use App\Libro;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libros = Libro::all();
        return $this->showAll($libros);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'titulo' => 'required|max:255|unique:libros,titulo',
            'descripcion' => 'required|max:255',
            
        ], [

            'titulo.required' => "El titulo del libro es obligatorio",
            'titulo.max' => "El libro solo puede contener hasta 255 caracteres",
            'titulo.unique' => "El titulo del libro ha de ser unico",
            'descripcion.required' => "La descripcion del libro es obligatoria",
            'descripcion.max' => "La descripcion solo puede contener hasta 255 caracteres",

        ]);

        if ($validator->fails()) {

            return $this->errorResponse($validator->errors(), 400);
        }

        $libro = new Libro();
        $libro->forceFill([

            'titulo' => $request->get('titulo'),
            'descripcion' => $request->get('descripcion'),
        ]);

        $libro->save();
        
        return $this->showOne($libro);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function show(Libro $libro)
    {
        return $this->showOne($libro);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function edit(Libro $libro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libro $libro)
    {
        $validator = Validator::make($request->all(), [

            'titulo' => 'required|max:255|unique:libros,titulo',
            'descripcion' => 'required|max:255',
            
        ], [

            'titulo.required' => "El titulo del libro es obligatorio",
            'titulo.max' => "El libro solo puede contener hasta 255 caracteres",
            'titulo.unique' => "El titulo del libro ha de ser unico",
            'descripcion.required' => "La descripcion del libro es obligatoria",
            'descripcion.max' => "La descripcion solo puede contener hasta 255 caracteres",

        ]);

        if ($validator->fails()) {

            return $this->errorResponse($validator->errors(), 400);
        }

        $libro->forceFill([

            'titulo' => $request->get('titulo'),
            'descripcion' => $request->get('descripcion'),
        ]);

        /*if(!$libro->isDirty()){
            return response()->json(['error'=>['code' => 422, 'message' => 'please specify at least one different value' ]], 422);
        }*/

        $libro->save();
        return $this->showOne($libro);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Libro  $libro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Libro $libro)
    {
        $libro->delete();
        return $this->showMessage("El libro se ha borrado con exito");

    }
}
