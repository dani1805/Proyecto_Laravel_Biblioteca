<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            'nombre' => 'required|max:255',
            'email' => 'required | email | unique:usuarios,email',
            'contrasenia' => 'required|min:6'
        ], [

            'nombre.required' => "El campo nombre es obligatorio",
            'nombre.max' => "El campo nombre debe contener como máximo hasta 255 caracteres",
            'email.required' => "El campo email es obligatorio",
            'email.email' => "Debes introducir un formato correcto para el email",
            'email.unique' => "Ya existe este email",
            'contrasenia.required' => "El campo contraseña es obligatorio",
            'contrasenia.min' => "El campo contraseña debe contener al menos 5 caracteres"

        ]);

        if ($validator->fails()) {

            return $this->errorResponse($validator->errors(), 400);
        }
        
        $usuario = new Usuario();
        $usuario->forceFill([

            'nombre' => $request->get('nombre'),
            'email' => $request->get('email'),
            'contrasenia' => $request->get('contrasenia')
        ]);

        $usuario->save();

        $token = JWTAuth::fromUser($usuario);

        return $this->showOneWithToken($usuario, $token);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }

    public function prestar(Usuario $usuario, Request $request) {

        $validator = Validator::make($request->all(), [

            'id' => 'required',
            
        ], [

            'id.required' => "El campo id es obligatorio",

        ]);

        if ($validator->fails()) {

            return $this->errorResponse($validator->errors(), 400);
        }

        $auth = JWTAuth::parseToken()->authenticate();
        if ($auth != $usuario) {

            return $this->showMessage("Usuario no autorizado", 401);
        }

        $usuario->libros()->attach($request->get('id'));
        return $this->showMessage("El libro se ha prestado con exito");




    }
}
