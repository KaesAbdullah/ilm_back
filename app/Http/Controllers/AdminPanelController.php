<?php

/**
 * Este es el controlador principal del administrador.
 */

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\User;

class AdminPanelController extends Controller
{
    // Esta funcion servira para muestra de informacion general del panel principal
    public function informacionGeneral()
    {
        $totalUsuarios = User::count(); // Esto obtiene el total de usuarios general.
        $totalPorfes = User::where('rol', 'profe')->count(); // Esto obtiene el total de profesores.
        $totalAlumnos = User::where('rol', 'alumno')->count(); // Esto obtiene el total de alumnos.
        $usuariosLista = User::where('rol', '!=', 'admin')
        ->orderBy('id', 'asc')->take(7)->get(); // Esto obtiene los primeros 7 usuarios, profe o alumno.

        return view('inicio', compact('totalUsuarios', 'totalPorfes', 'totalAlumnos', 'usuariosLista'));
    }
}
