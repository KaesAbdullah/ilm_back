<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Laravel ya crea por si mismo las funciones necesarias para su login.
     * Llamando al "LoginRequest.php", usa sus diferentes funciones.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Esta funcion verifica si hay errores en las credenciales.
        $request->session()->regenerate(); // Este, segun me he informado, previene ataques de sesion.

        // Este if verifica si el usuario es admin o no.
        if (auth()->user()->rol !== 'admin') {
            Auth::logout();

            return back()->withErrors([
                'email'=> 'No tienes permiso para acceder.' // Error que se mostrará en la componente de errores.
            ])->onlyInput('email');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
