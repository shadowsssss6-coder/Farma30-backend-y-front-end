<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $usuario = User::where('email', $request->email)->first();

        if (! $usuario || ! Hash::check($request->password, $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => ['Correo o contrasena incorrectos.'],
            ]);
        }

        $token = $usuario->createToken('farma30-web')->plainTextToken;

        return response()->json([
            'token' => $token,
            'usuario' => new UsuarioResource($usuario),
        ]);
    }

    public function registrar(RegistroRequest $request)
    {
        $usuario = User::create([
            'name' => $request->nombre_del_integrante ?? $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'numero_de_contacto' => $request->numero_de_contacto,
            'nombre_del_integrante' => $request->nombre_del_integrante,
        ]);

        $token = $usuario->createToken('farma30-web')->plainTextToken;

        return response()->json([
            'token' => $token,
            'usuario' => new UsuarioResource($usuario),
        ], 201);
    }

    public function recuperarClave(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        return response()->json(['mensaje' => 'Si el correo existe, se enviaron las instrucciones.']);
    }

    public function actualizarPerfil(Request $request)
    {
        $usuario = $request->user();
        $usuario->update($request->only(['numero_de_contacto', 'nombre_del_integrante']));

        return new UsuarioResource($usuario);
    }

    public function cerrarSesion(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensaje' => 'Sesion cerrada.']);
    }
}