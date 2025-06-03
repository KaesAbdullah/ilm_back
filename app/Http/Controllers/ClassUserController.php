<?php

namespace App\Http\Controllers;

use App\Models\ClassUser;
use Illuminate\Http\Request;

class ClassUserController extends Controller
{
    // MOSTRAR TODOS
    public function index()
    {
        return ClassUser::all();
    }

    // MOSTRAR POR ID
    public function show(string $id)
    {
        $busqueda = ClassUser::find($id);

        if (!$busqueda)
            return response()->json(['mensaje' => 'No se encuentra'], 404);

        return response()->json($busqueda);
    }

    // CREAR UNO NUEVO
    public function store(Request $request)
    {
        $datosValidar = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'clase_id' => 'required|exists:classes,id',
        ]);

        $crear = ClassUser::create($datosValidar);

        return response()->json(['mensaje' => 'Creado', 'data' => $crear]);
    }

    // EDITAR UNO DADO SU ID
    public function update(Request $request, string $id)
    {
        $busqueda = ClassUser::find($id);

        if (!$busqueda)
            return response()->json(['mensaje' => 'No se encuentra'], 404);

        $datosValidar = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'clase_id' => 'required|exists:classes,id',
        ]);

        $busqueda->usuario_id = $datosValidar['usuario_id'];
        $busqueda->clase_id = $datosValidar['clase_id'];
        $busqueda->save();

        return response()->json(['mensaje' => 'Editado', 'data' => $busqueda]);
    }

    // ELIMINAR UNO DADO SU ID
    public function destroy(string $id)
    {
        $busqueda = ClassUser::find($id);

        if (!$busqueda)
            return response()->json(['mensaje' => 'No se encuentra'], 404);

        $busqueda->delete();

        return response()->json(['mensaje' => 'Eliminado']);
    }
}
