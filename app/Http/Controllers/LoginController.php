<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use \Firebase\JWT\JWT;


class LoginController extends Controller
{
    //

    /** Realiza o login do usuário */
    public function login(Request $request) {
        $usuario = Usuario::where('login', $request->login)->where('senha', md5($request->senha))->firstOrFail();

        $token = ['id' => $usuario->id, 'email' => $usuario->email];
        $jwt = JWT::encode($token, config('jwt.key'));
        
        return response()->json($jwt);   
    }
}
