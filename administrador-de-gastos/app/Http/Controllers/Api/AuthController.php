<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Date as ModelsDate;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData))
        {
            return response()->json([
                'response' => 'Contraseña o correo incorrecto',
            ], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        
        return response()->json([
            'profile' => auth()->user(),
            'access_token' => $accessToken,
            'message' => 'success'
        ]);
    }
}

