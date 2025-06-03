<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize(): bool
    {
        return true;
    }

    // Estas son las reglas establecidas del
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    // Esta funcoion verifica si las credenciales son correctas.

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Este metodo creado por Laravel, sirve para proteger de ataques brutos.
     * Lo voy a dejar, porque es interesante.
     */
    public function ensureIsNotRateLimited(): void
    {
        // Esto comprueba si se han intentado mas de 5 intentos.
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));


        /**
         *  Esto, son los segundos de restriccion por intentos fallidos.
         *  Determina el tiempo que hay hasta que pueda intentar otra vez.
         */
        $seconds = RateLimiter::availableIn($this->throttleKey());

        // Esto lanza un mensaje especializado, explicando cuanto tiempo falta.
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    // Esto "guarda" el usuario [su email e IP], para la accion.

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
