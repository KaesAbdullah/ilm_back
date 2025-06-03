<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\ClassUserController;
use App\Http\Controllers\LoginController;
use App\Models\Asistencia;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
// Parece que gracias al apiResource... no necesito crear ninguna ruta más!
// Este metodo cubre todo! Con tan solo crear una ruta por tipo, suficiente.
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('clases', ClaseController::class);
Route::apiResource('asistencias', AsistenciaController::class);
Route::apiResource('reasons', ReasonController::class);
Route::apiResource('alumnoclase', ClassUserController::class);

// Para mostrar 4 alumnos del profe
Route::middleware('auth:sanctum')->get('/profesor/alumnosLeve', function (Request $request) {
    $profesor = $request->user();

    if ($profesor->rol !== 'profe') {
        return response()->json(['error' => 'Acceso no autorizadp'], 403);
    }

    $clase = $profesor->clase_profe()->first();

    if (!$clase) {
        return response()->json(['message' => 'No tienes ninguna clase'], 404);
    }

    $alumnos = $clase->alumnos()->where('rol', 'alumno')->take(4)->get(['nombre', 'apellido1', 'apellido2']);

    return response()->json($alumnos);
});

// Para mostrar todos los alumnos del profe
Route::middleware('auth:sanctum')->get('/profesor/alumnos', function (Request $request) {
    $profesor = $request->user();

    if ($profesor->rol !== 'profe') {
        return response()->json(['error' => 'Acceso no autorizadp'], 403);
    }

    $clase = $profesor->clase_profe()->first();

    if (!$clase) {
        return response()->json(['message' => 'No tienes ninguna clase'], 404);
    }

    // En vez de solo 4, esta vez, todos...
    $alumnos = $clase->alumnos()->where('rol', 'alumno')->get(['nombre', 'apellido1', 'apellido2']);

    return response()->json($alumnos);
});

// Esto mostrara todos los profes del alumno
Route::middleware('auth:sanctum')->get('/alumno/profesores', function (Request $request) {
    $alumno = $request->user();

    if ($alumno->rol !== 'alumno') {
        return response()->json(['error' => 'Acceso no autorizadp'], 403);
    }

    // Obtener los profes
    $profesores = $alumno->clases_alumno()->with('profesor:id,nombre,apellido1,apellido2,email,numero_telefono')
        ->get()->pluck('profesor')->values();

    if (!$profesores) {
        return response()->json(['message' => 'No tienes profesores'], 404);
    }

    return response()->json($profesores);
});

// Para las asistencias.
Route::post('/asistencias/batch', [AsistenciaController::class, 'storeBatch'])->middleware('auth:sanctum');

// Esto servira para las justificaciones del alumno
Route::middleware('auth:sanctum')->get('/alumno/faltas', function (Request $request) {
    $alumno = $request->user();

    $faltas = Asistencia::with(['justificacion', 'clase'])->where('alumno_id', $alumno->id)
        ->where('estado', false)->get()
        ->map(function ($asistencia) {
            return [
                'asistencia_id' => $asistencia->id,
                'fecha' => $asistencia->fecha,
                'clase' => $asistencia->clase->nombre,
                'motivo' => $asistencia->justificacion?->estado ?? 'Sin justificar',
                'estado' => $asistencia->justificacion?->estado ?? false,
            ];
        });

    return response()->json($faltas);
});
