<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clase;
use Illuminate\Http\Request;

class ClaseAlumnoController extends Controller
{
    /** GESTION GENERAL DE LOS ALUMNOS
     * Esto servira para mostrar las dos tablas. Una, para los alumnos en la clase de cierta ID.
     * Otra, que muestra todos los alumnos, para añadir nuevos.
     */
    public function gestionarAlumnos($id)
    {
        $clase = Clase::findOrFail($id);
        $alumnos_en_clase = $clase->alumnos;
        $alumnosGeneral = User::where('rol', 'alumno')
            ->whereNotIn('id', $alumnos_en_clase->pluck('id'))->get();

        return view('ClaseAlumno', compact('clase', 'alumnosGeneral', 'alumnos_en_clase'));
    }

    // Con esto se agregan nuevos alumnos a la clase con cierta ID.
    public function agregarAlumno(Request $request, $id)
    {
        $clase = Clase::findOrFail($id);
        $clase->alumnos()->attach($request->alumno_id);

        return  back()->with('agregado', 'El alumno fue añadido a la clase.');
    }

    // Esta funcion, elimina a alumnos de la clase de su la ID.
    public function eliminarAlumno($id, $id_alumno)
    {
        $clase = Clase::findOrFail($id);
        $clase->alumnos()->detach($id_alumno);

        return back()->with('eliminado', 'El alumno fue eliminado de la clase.');
    }
}
