<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;

class FrontUsuarioController extends Controller
{
    /**METODO PARA LA VISTA DE CREACION
     * Este servira para mostrar la vista del formulario de creacion de usuario.
     * El campo "$clases" sirve para más tade mostrar las clases disponibles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View - Devuelve la vista + las clases
     */
    public function create()
    {
        $clases = Clase::all();
        $usuario = null;

        return view('CrearUsaurioForm', compact('clases', 'usuario'));
    }

    /** METODO PARA CREAR USUARIOS
     * Este metodo "store" servira para crear usuarios.
     * Como ya he creado un metodo similar para la API, tan solo
     * lo rehuso y modifico.
     */
    public function store(Request $request)
    {
        $datosValidar = $request->validate([
            'dni' => 'required|unique:users|regex:/^[0-9]{8}[A-Z]$/',
            'rol' => 'required|in:admin,profe,alumno',
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F',
            'numero_telefono' => 'required|regex:/^\d{9}$/',
            'email' => 'required|email|unique:users',
        ]);

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
        $usuario->password = bcrypt('pwd123');

        $usuario->save();

        if ($usuario->rol === 'alumno' && $request->has('clase')) {
            $usuario->clases_alumno()->sync($request->input('clase'));
        }

        return redirect()->route('usuarios')->with('success', 'Usuario creado correctamente.');
    }

    /** METODO PARA LA VISTA DE EDICION
     * Vamos a usar la misma vista de creacion de usuario, para no rehacer y complicar todo.
     * Lo unico que se necesita es la ID, para luego rellenar los campos.
     *
     * @param mixed $id el ID del usuario.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View - Esto es la vista con el usuario
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $clases = Clase::all();

        return view('CrearUsaurioForm', compact('usuario', 'clases'));
    }


    /** METODO PARA EDITAR USUARIOS
     * Este metodo "update" servira para editar usuarios.
     * Como ya he creado un metodo similar para la API, tan solo
     * lo rehuso y modifico.
     *
     * Se usa el ID del usuario para encontrarlo en la BD.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

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

        return redirect()->route('usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    /** METODO PARA ELIMINAR USUARIOS
     * Este metodo "destroy" servirá para eliminar ciertos usuarios.
     * Se usa el ID del usuario para encontrarlo en la BD. Si el usuario es admin, no le deja eliminar.
     * Si es profesor, y tiene una clase asignada, no se deja eliminar. Pero si no tiene clase, se puede eliminar.
     * En cambio, si es alumno, primero se le elimina la relacion con su clase, y luego, se elimina al usuario.
     *
     * Esta logica se debe porque, lo que yo pienso, es que un profesor no puede ser eliminado de una clase llena
     * de alumnos. Puede que editar y añadir otro profesor si.
     *
     * Aparte de esto, se usa un "try-catch" para otros errores que ocurran en el proceso.
     *
     * @param mixed $id Este es el ID del usuario.
     * @return \Illuminate\Http\RedirectResponse Devuelve la respuesta.
     */
    public function destroy($id)
    {
        try {
            $usuario = User::findOrFail($id);

            if ($usuario->rol === 'admin')
                return redirect()->back()->with('error', 'No se puede eliminar un administrador.');

            if ($usuario->rol === 'profe' && $usuario->clase_profe()->exists())
                return redirect()->back()->with('error', 'No se puede eliminar un profesor con clase asignada.');

            if ($usuario->rol === 'alumno')
                $usuario->clases_alumno()->detach();

            $usuario->delete();
            return redirect()->route('usuarios')->with('success', 'El usuario ha sido eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $error) {
            return redirect()->back()->with('error', 'Hubo un error en la base de datos...');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', 'Hubo un error inesperado...');
        }
    }
}
