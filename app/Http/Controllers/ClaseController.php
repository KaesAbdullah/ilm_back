<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    // MUESTRA GENERAL: Esto mostrará todas las clases
    public function index()
    {
        return Clase::all();
    }

    // MUESTRA POR ID: Dada la ID de la clase, se muestra
    public function show(string $id)
    {
        $clase = Clase::find($id);

        if (!$clase)
            return response()->json(['mensaje' => 'Clase no encontrada'], 404);

        return response()->json($clase);
    }


    // CREAR CLASE: Dado el request, se creará una clase
    public function store(Request $request)
    {
        $datosValidar = $request->validate([
            'nombre' => 'required|string|max:255',
            'profe_id' => 'required|integer|unique:classes,profe_id',
            'tipo' => 'required|in:arabe,religion',
            'nivel' => 'required|string|max:255',
            'imagen_horario' => 'required|string|max:255',
        ]);

        $clase = new Clase();
        $clase->nombre = $datosValidar['nombre'];
        $clase->profe_id = $datosValidar['profe_id'];
        $clase->tipo = $datosValidar['tipo'];
        $clase->nivel = $datosValidar['nivel'];
        $clase->numero_alumnos = 0; // numero de alumnos sera 0 por defecto
        $clase->imagen_horario = $datosValidar['imagen_horario'];

        $clase->save();

        return response()->json(['mensaje' => 'Clase creada', 'data' => $clase]);
    }


    // ACTUALIZAR UNA CLASE: Con esto, dado el ID, la request que se recibe, se aztualiza una clase
    public function update(Request $request, string $id)
    {
        $clase = Clase::find($id);

        if (!$clase)
            return response()->json(['mensaje' => 'Clase no encontrada'], 404);

        $datosValidar = $request->validate([
            'nombre' => 'required|string|max:255',
            'profe_id' => 'required|integer|unique:classes,profe_id,' . $id,
            'tipo' => 'required|in:arabe,religion',
            'nivel' => 'required|string|max:255',
            'imagen_horario' => 'required|string|max:255',
        ]);

        $clase->nombre = $datosValidar['nombre'];
        $clase->profe_id = $datosValidar['profe_id'];
        $clase->tipo = $datosValidar['tipo'];
        $clase->nivel = $datosValidar['nivel'];
        $clase->imagen_horario = $datosValidar['imagen_horario'];

        $clase->save();

        return response()->json(['mensaje' => 'Clase actualizada', 'data' => $clase]);
    }

    // ELIMINAR UNA CLASE: Dada el id.
    public function destroy(string $id)
    {
        $clase = Clase::find($id);

        if (!$clase)
            return response()->json(['mensaje' => 'Clase no encontrada'], 404);

        $clase->delete();

        return response()->json(['mensaje' => 'Clase eliminada']);
    }
}
