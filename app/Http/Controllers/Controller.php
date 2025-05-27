<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\HtmlString;
use App\Utils\Meta;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data) {
        return response()->json($data, Response::HTTP_OK);
    }

    public function not_found() {

    }

    public function unauthorized(string $message = '', array $errors = []) {
        return response()->json([
            'message' => $message,
            'data' => $errors
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function error(string $message) {
        return response()->json([
            'message' => $message,
            'data' => []
        ], Response::HTTP_BAD_GATEWAY);
    }

    public function failed(string $message, array $errors = []) {
        return response()->json([
            'message' => $message,
            'data' => $errors
        ], Response::HTTP_BAD_REQUEST);
    }

    public function GetAuthUser() {
        // $publicHelper = new PublicHelper();
        $service = new JWTService;
        $token = $service->GetAndDecodeJWT();

        $userID = $token->data->userID;
        $user = User::where('id', $userID)->first();
        return $user;
    }

    public function render(string $view, array $data) {
        $data['user'] = auth()->user();
        return view($view, $data);
    }

    public function showVueRoute() {
        if (app()->environment('local')) {
            $prod = false;
        } else { $prod = true;}
        return view('welcome', ['production' => $prod, 'assets' => Meta::vite_assets()]);
    }
}
