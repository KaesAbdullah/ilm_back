<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ListaUsuariosController extends Controller
{
    public function index(Request $request)
    {
        // Defino una variable con un valor default de 1.
        // Esta se usuara más tarde para trabajar con la paginacion.
        $pagina = $request->input('page', 1);
        $numeroMuestra = 7; // Esto es el numero maximo que muestra por pagina.
        $dni = $request->input('dni'); // Variable que obtiene el dni del formulario de busqueda.

        // Este es un "if" que determina si se ha encontrado un dni, o no.
        // Si se busca, se consulta en la bd, obteniendo el usuario.
        if ($dni) {
            $usuarios = User::where('dni', $dni)->get();
            $tieneMas = false;
            return view('ListaUsuarios', compact('usuarios', 'pagina', 'tieneMas'));
        }
        // Si no, se hace lo normal, mostrando los demas.

        $usuarios = User::where('rol', '!=', 'admin') // No queremos admin.
            ->skip(($pagina - 1) * $numeroMuestra) // Aqui se saltan usuarios dependiendo de la pagina.
            // Aqui el take, aparte de obtener el numero de usuarios, sirve para saber si hay mas usuarios
            // o no en la siguiente pagina. Por ello, el + 1.
            ->take($numeroMuestra + 1)->get();

        $tieneMas = $usuarios->count() > $numeroMuestra; // Variable que funciona como boolean, detrminando si se muestra un boton, o no.
        $usuarios = $usuarios->take($numeroMuestra); // El numero de usuarios que muestra en orden.

        return view('ListaUsuarios', compact('usuarios', 'pagina', 'tieneMas'));
    }
}
