<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** Inicio de sesion y creacion de token */
    public function login(Request $request){
        try {
            $status = 200;
            $request->validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);

            $credentials = request(['email', 'password']);

            if (!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'No autorizado'
                ], 401);

            $user = $request->user();
            $tokenResult = $user->createToken('Token de acceso personal');

            $token = $tokenResult->token;
            $token->save();

            $json = [
                'ok' => true,
                'access_token' => $tokenResult->accessToken,
                'user' => $user,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ];
        }catch (\Exception $error){
            $status = 400;
            $json = [
                'ok' => false,
                'message' => $error->getMessage()
            ];
        }
        return response()->json($json, $status);
    }

    /** Cierre de sesion */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Sesion cerrada'
        ]);
    }
}
