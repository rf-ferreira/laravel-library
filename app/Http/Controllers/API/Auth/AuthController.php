<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => 'nullable',
            'name' => 'required|string',
            'email' => 'email|required',
            'password' => 'required|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if (User::create($validated)) {
            $response = [
                'status' => 200,
                'message' => 'success'
            ];
            return response()->json($response);
        }

        $response = [
            'status' => 401,
            'message' => 'not authorized',
        ];
        return response()->json($response, 401);

    }

    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('access_token')->plainTextToken;

            $response = [
                'status' => 200,
                'message' => 'success',
                'access_token' => explode('|', $token)[1],
                'token_type' => 'Bearer',
            ];
            return response()->json($response, 200);
        }

        $response = [
            'status' => 401,
            'message' => 'not authorized',
        ];
        return response()->json($response, 401);
    }
}
