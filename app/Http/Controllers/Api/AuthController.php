<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['register', 'login']),
        ];
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->assignRole('operador');

        // iniciar sesión y devolver recurso
        $token = auth('api')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            'active' => true,
        ]);

        return new AuthResource(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        if (! $token = auth('api')->attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            'active' => true,
        ])) {
            return response()->json([
                'message' => 'Credenciales inválidas o usuario inactivo'
            ], 401);
        }

        return new AuthResource(['user' => auth('api')->user(), 'token' => $token]);
    }

    public function me()
    {
        $user = auth('api')->user();

        return new UserResource($user);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['mensaje' => 'Cierre de sesión exitoso']);
    }

    public function refresh()
    {
        $token = Auth::refresh();

        return new AuthResource(['user' => auth('api')->user(), 'token' => $token]);
    }
}
