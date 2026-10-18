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
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente', // nunca se toma del cliente HTTP
            'numero_de_contacto' => $request->numero_de_contacto,
    ]);

        $token = $usuario->createToken('farma30-web')->plainTextToken;

        return response()->json([
            'token' => $token,
            'usuario' => new UsuarioResource($usuario),
        ], 201);
    }

    public function crearIntegrante(Request $request)
    {
    abort_unless($request->user()->esAdministrador(), 403, 'Solo un administrador puede crear integrantes.');

    $datos = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'nombre_del_integrante' => 'required|string|max:255',
    ]);

    $integrante = User::create([
        'name' => $datos['nombre_del_integrante'],
        'email' => $datos['email'],
        'password' => Hash::make($datos['password']),
        'rol' => 'integrante',
        'nombre_del_integrante' => $datos['nombre_del_integrante'],
    ]);

    return (new UsuarioResource($integrante))->response()->setStatusCode(201);
    });
}
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensaje' => 'Sesion cerrada.']);
    }
}
