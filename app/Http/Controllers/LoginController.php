<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credendciales erroneas'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        if (empty($token)) {
            Log::error('Token no generado para el usuario: ' . $user->id);
        }

        // Esto servira para que, al logearse, se guarden y devuelkvan los datos necesarios para elAngular.
        return response()->json([
            'token' => $token,
            'rol' => $user->rol,
            'id' => $user->id,
            'nombre' => $user->nombre,
        ]);
    }
}
