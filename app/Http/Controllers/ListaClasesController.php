<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;

class ListaClasesController extends Controller
{
    public function index(Request $request)
    {
        $pagina = $request->input('page', 1);
        $numeroMuestra = 7;
        $nombre_clase = $request->input('nombre_clase');
        // Para poder mostrar nombre en en vez de ID.
        $clases = Clase::with('profesor')->get();

        // El if determina si se encuentra la clase.
        if ($nombre_clase) {
            $clases = Clase::where('nombre', $nombre_clase)->get();
            $tieneMas = false;
            return view('ListaClases', compact('clases', 'pagina', 'tieneMas'));
        }

        $clases = Clase::skip(($pagina - 1) * $numeroMuestra)->take($numeroMuestra + 1)->get();

        $tieneMas = $clases->count() > $numeroMuestra; // Variable que funciona como boolean, detrminando si se muestra un boton, o no.
        $clases = $clases->take($numeroMuestra); // El numero de usuarios que muestra en orden.

        return view('ListaClases', compact('clases', 'pagina', 'tieneMas'));
    }
}
