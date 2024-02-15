<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function signup(CreateUserRequest $request)
    {
        $data = $request->validated();
    
    
        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_admin' => $data['is_admin'] ?? false
            
           
        ]);

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }
    public function login(LoginRequest $request)
    {
         // Validar las credenciales del usuario
         $credentials = $request->only('email', 'password');

         try {
             // Intentar autenticar al usuario y generar el token JWT
             if (!$token = JWTAuth::attempt($credentials)) {
                 return response()->json(['message' => 'Email or password is incorrect'], 422);
             }
         } catch (JWTException $e) {
             return response()->json(['message' => 'Could not create token'], 500);
         }
 
         // Obtener el usuario autenticado
         $user = auth()->user();
 
         // Verificar si el usuario es un administrador
         if (!$user->is_admin) {
             return response()->json(['message' => 'You don\'t have permission to authenticate as admin'], 403);
         }
 
         // Verificar si el email del usuario está verificado
         if (!$user->email_verified_at) {
            Auth::logout();
            return response()->json(['message' => 'Your email address is not verified'], 403);
        }
 
         // Devolver la respuesta con el usuario y el token JWT
         return response()->json([
             'user' => new UserResource($user),
             'token' => $token
         ]);
     

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
        return response('', 204);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
}