<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    // MOSTRARA TODAS LAS ASISTENCIAS
    public function index()
    {
        return Asistencia::all();
    }

    // MOSTRARA UNA ASISTENCIA DADO EL ID
    public function show(string $id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia)
            return response()->json(['mensaje' => 'Asistencia no encontrada'], 404);

        return response()->json($asistencia);
    }

    // CREARA UNA NUEVA
    public function store(Request $request)
    {
        $datosValidar = $request->validate([
            'fecha' => 'required|date',
            'clase_id' => 'required|exists:classes,id',
            'alumno_id' => 'required|exists:users,id',
            'estado' => 'required|boolean'
        ]);

        $asistencia = new Asistencia();
        $asistencia->fecha = $datosValidar['fecha'];
        $asistencia->clase_id = $datosValidar['clase_id'];
        $asistencia->alumno_id = $datosValidar['alumno_id'];
        $asistencia->estado = $datosValidar['estado'];

        $asistencia->save();

        return response()->json(['mensaje' => 'Asistencia creada', 'data' => $asistencia]);
    }

    // Actualiza una asistencia (posiblemente no sea necesaria)
    public function update(Request $request, string $id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia)
            return response()->json(['mensaje' => 'Asistencia no encontrada'], 404);

        $datosValidar = $request->validate([
            'fecha' => 'required|date',
            //'clase_id' => 'required|exists:classes,id,' . $id,
            //'alumno_id' => 'required|exists:users,id,' . $id,
            'estado' => 'required|boolean'
        ]);

        $asistencia->fecha = $datosValidar['fecha'];
        //$asistencia->clase_id = $datosValidar['clase_id'];
        //$asistencia->alumno_id = $datosValidar['alumno_id'];
        $asistencia->estado = $datosValidar['estado'];

        $asistencia->save();

        return response()->json(['mensaje' => 'Asistencia actualizada', 'data' => $asistencia]);
    }

    // Elimina una asistencia
    public function destroy(string $id)
    {
        $asistencia = Asistencia::find($id);

        if (!$asistencia)
            return response()->json(['mensaje' => 'Asistencia no encontrada'], 404);

        $asistencia->delete();

        return response()->json(['mensaje' => 'Asistencia eliminada']);
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            '*.fecha' => 'required|date',
            '*.clase_id' => 'required|exists:classes,id',
            '*.alumno_id' => 'required|exists:classes,id',
            '*.estado' => 'required|boolean',
        ]);

        $asistencias = [];
        foreach ($request->all() as $datos) {
            $asistencias[] = Asistencia::create($datos);
        }

        return response()->json([
            'mensaje' => 'Asistencia guardadas',
            'data' => $asistencias
        ]);
    }
}
