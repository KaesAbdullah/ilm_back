<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    // Esto mostrara todas las justificaciones
    public function index()
    {
        return Reason::all();
    }

    // Esto mostrará una justificacion por ID
    public function show(string $id)
    {
        $reason = Reason::find($id);

        if (!$reason)
            return response()->json(['mensaje' => 'Justificacion no encontrada'], 404);

        return response()->json($reason);
    }


    // Esto creara una nueva justificacion
    public function store(Request $request)
    {
        $datosValidar = $request->validate([
            'asistencia_id' => 'required|exists:attendance,id|unique:reason,asistencia_id',
            'motivo' => 'required|string',
            'estado' => 'required|boolean',
        ]);

        $justificante = Reason::create($datosValidar); // Una manera mas rapida

        return response()->json(['mensaje' => 'Justificante creado', 'data' => $justificante]);
    }


    public function update(Request $request, string $id)
    {
        // No sera necesaria esta, ya que, de momento, no se pueden editar.
    }

    public function destroy(string $id)
    {
        // Esta tampoco. De momento, no se puede eliminar.
    }
}
