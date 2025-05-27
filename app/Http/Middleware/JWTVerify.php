<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use Exception;
use App\Services\JWTService;
use App\Models\TokenBlacklist;
use Illuminate\Support\Facades\Log;


class JWTVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $publicHelper = new JWTService;

        try {
            
            $token = $publicHelper->GetAndDecodeJWT();
            Log::info(json_encode($token));
            if ($token && TokenBlacklist::where('token_id', base64_encode($token))->exists()) {
                return response()->json(['error' => 'Token revoked'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
