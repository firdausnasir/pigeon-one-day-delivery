<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        if (\Auth::attempt($data) === false) {
            return response()->json([
                'message' => 'Wrong credentials given'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user  = \Auth::user();
        $token = $user->createToken('order_token');

        return response()->json([
            'message' => 'Authenticated',
            'data'    => [
                'user_id'      => $user->id,
                'name'         => $user->name,
                'access_token' => $token->plainTextToken
            ]
        ]);
    }
}
