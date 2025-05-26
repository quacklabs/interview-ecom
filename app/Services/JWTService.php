<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use App\Exceptions\AuthenticationException;
use Exception;
use App\Models\User;
use App\Models\TokenBlacklist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JWTService
{
    public function GenerateToken($user)
    {
        $secretKey  = env('JWT_SECRET');
        $tokenId    = base64_encode(random_bytes(16));
        $issuedAt   = new DateTimeImmutable();
        $expire     = $issuedAt->modify('+3 hours')->getTimestamp();     
        $serverName = env('APP_URL');
        $userID   = $user->id;                                    

        // Create the token as an array
        $data = [
            'iat'  => $issuedAt->getTimestamp(),    
            'jti'  => $tokenId,                     
            'iss'  => $serverName,                  
            'nbf'  => $issuedAt->getTimestamp(),    
            'exp'  => $expire,                      
            'data' => [                             
                'userID' => $userID,            
            ]
        ];

    // Encode the array to a JWT string.
        $token = JWT::encode(
            $data,      
            $secretKey, 
            'HS256'     
        );
        return $token;
    }


    // get jwt info from header
    public function GetRawJWT()
    {
        $request = Request::capture();
        if(empty($request->header('Authorization'))) {
            throw new AuthenticationException('Authorization header not found');
        }

        // check if bearer token exists
        if (! preg_match('/Bearer\s(\S+)/', $request->header('Authorization'), $matches)) {
            throw new AuthenticationException('token not found');
        }

        // extract token
        $jwt = $matches[1];
        if (!$jwt) {
            throw new AuthenticationException('could not extract token');
        }

        return $jwt;
    }


    public function DecodeRawJWT($jwt)
    {
        // use secret key to decode token
        $secretKey  = env('JWT_SECRET');
        try {
            $token = JWT::decode($jwt, new Key($secretKey, 'HS256'));
            $now = new DateTimeImmutable();
        } catch(Exception $e) {

            throw new AuthenticationException('Unauthorized');
        }

        return $token;
    }

    public function GetAndDecodeJWT()
    {
        $jwt = $this->GetRawJWT();
        $token = $this->DecodeRawJWT($jwt);

        return $token;
    }

    public function refreshToken() {
        $jwt = $this->GetRawJWT();

        $secretKey  = env('JWT_SECRET');
        $token = JWT::decode($jwt, new Key($secretKey, 'HS256'));
        $expirationTime = $token->exp;
        $expirationTime = Carbon::createFromTimestamp($token->exp);
        $currentTime = Carbon::now();
        $expirationThreshold = 5;

        if ($expirationTime->diffInMinutes($currentTime) < $expirationThreshold) {
            // Generate a new token with an updated expiration time
            $user = User::find($token->data->userID);
            if($user) {
                $newToken = $this->GenerateToken($user);
                return $newToken;
            }
            return [];
            
        } else {
            // Token is still valid, no need to refresh
            return ['token' => $token];
        }
    }

    public function revokeToken() {
        $jwt = $this->GetRawJWT();
        TokenBlacklist::create(['token_id' => base64_encode($jwt)]);
        return;
    }
}