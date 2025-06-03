<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ClaseAlumnoController;
use App\Http\Controllers\FrontClasesController;
use App\Http\Controllers\FrontUsuarioController;
use App\Http\Controllers\ListaClasesController;
use App\Http\Controllers\ListaUsuariosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/inicio', [AdminPanelController::class, 'informacionGeneral'])
    ->middleware(['auth'])
    ->name('inicio');


/**
 * Agrupamos estas rutas con middleware, para "seguridad".
 * De esta manera no es necesario siempre usarlo en cada ruta.
 *
 * Se usan las rutas GET para las vistas.
 * Luego el POST para creacion de usuarios, usando el metodo "store".
 * Luego, el PUT para editar usuarios dado su ID, usando el metodo "edit".
 * Y finalmente el metodo DELETE, para eliminar un usuario dado su ID, y se usa el metodo "destroy".
 */
Route::middleware('auth')->group(function () {
    // PARTE DE USUARIOS
    // Vistas
    Route::get('/usuarios', [ListaUsuariosController::class, 'index'])->name('usuarios');
    Route::get('/usuarios/crear', [FrontUsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/editar/{id}', [FrontUsuarioController::class, 'edit'])->name('usuarios.edit');
    // Peticiones
    Route::post('/usuarios', [FrontUsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [FrontUsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [FrontUsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // PARTE DE CLASES
    // Vistas
    Route::get('/classes', [ListaClasesController::class, 'index'])->name('classes');
    Route::get('/classes/crear', [FrontClasesController::class, 'create'])->name('classes.create');
    Route::get('/classes/editar/{id}', [FrontClasesController::class, 'edit'])->name('classes.edit');
    Route::get('/classes/{id}/alumnos', [ClaseAlumnoController::class, 'gestionarAlumnos'])->name('classes.gestionarAlumnos');
    // Peticiones
    Route::post('/classes/crear', [FrontClasesController::class, 'store'])->name('classes.store');
    Route::put('/classes/{id}', [FrontClasesController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{id}', [FrontClasesController::class, 'destroy'])->name('classes.destroy');
    Route::post('/classes/{id}/alumnos/agregar', [ClaseAlumnoController::class, 'agregarAlumno'])->name('classes.agregarAlumno');
    Route::delete('/classes/{id}/alumnos/{id_alumno}', [ClaseAlumnoController::class, 'eliminarAlumno'])->name('classes.eliminarAlumno');
});

// Con esta ruta, el usuario se desloguea.
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

/**
 * Route::middleware('auth')->group(function () {
 *   Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
 *  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 *  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 *});
 */

require __DIR__ . '/auth.php';
