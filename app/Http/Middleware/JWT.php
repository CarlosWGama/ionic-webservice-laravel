<?php

namespace App\Http\Middleware;

use Closure;

class JWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {
            if (!$request->is('api/login') && !$request->is('api/usuario')) {
                $dados = \Firebase\JWT\JWT::decode($request->header('Authorization'), config('jwt.key'), ['HS256']);
                if (empty($dados))
                    return response()->json("Acesso negado", 403);
            }
        } catch(\Exception $e) {
            return response()->json("Acesso negado", 403);
        }
        return $next($request);
    }
}
