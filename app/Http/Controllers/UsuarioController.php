<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // MUESTRA GENERAL: Mostraria los usuarios en general
    public function index()
    {
        return User::all();
    }


    // MUESTRA POR ID: Dependiendo del id, se muestra
    public function show(string $id)
    {
        $usuario = User::find($id); // Busca el usuario por ID

        if (!$usuario)
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);


        return response()->json($usuario);
    }

    // AÑADIR USUARIO: Se usara para crear nuevos users
    public function store(Request $request)
    {
        // Estos son los datos que se validan
        $datosValidar = $request->validate([
            'dni' => 'required|unique:users|max:255',
            'rol' => 'required|in:admin,profe,alumno',
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F',
            'numero_telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
        ]);

        // Luego se crea el usuario, paso a paso
        $usuario = new User();
        $usuario->dni = $datosValidar['dni'];
        $usuario->rol = $datosValidar['rol'];
        $usuario->nombre = $datosValidar['nombre'];
        $usuario->apellido1 = $datosValidar['apellido1'];
        $usuario->apellido2 = $datosValidar['apellido2'];
        $usuario->fecha_nacimiento = $datosValidar['fecha_nacimiento'];
        $usuario->genero = $datosValidar['genero'];
        $usuario->numero_telefono = $datosValidar['numero_telefono'];
        $usuario->email = $datosValidar['email'];
        $usuario->password = bcrypt('pwd123'); // El password lo genera automatico

        $usuario->save(); // Se guarda el usuario creado en la bd

        return response()->json($usuario);
    }


    // EDITAR USUARIO: Para la edicion de un usuario dado su ID
    public function update(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario)
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);

        $request->validate([
            'dni' => 'required|max:255|unique:users,dni,' . $id, // Al poner este id, se puede excluir
            'rol' => 'required|in:admin,profe,alumno',
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F',
            'numero_telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Una manera de acrtualizar los datos, revibiendo los nuevos..
        $usuario->dni = $request->dni;
        $usuario->rol = $request->rol;
        $usuario->nombre = $request->nombre;
        $usuario->apellido1 = $request->apellido1;
        $usuario->apellido2 = $request->apellido2;
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->genero = $request->genero;
        $usuario->numero_telefono = $request->numero_telefono;
        $usuario->email = $request->email;
        $usuario->password = bcrypt('pwd123'); // De momento, contraseña fija

        $usuario->save(); // Guardar los datos nuevos

        return response()->json(['mensaje' => 'Usuario actualizado', 'data' => $usuario]);
    }

    // ELIMINAR USUARIO: Para eliminar un usuario dado su ID
    public function destroy(string $id)
    {
        $usuario = User::find($id); // Se busca el usuario dado el ID

        if (!$usuario)
            return response()->json(['mensaje' => 'Usuario no encontrado'], 404);

        $usuario->delete(); // Elimina el usuario

        return response()->json(['mensaje' => 'Usuario eliminado']);
    }
}
