<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required | string',
                'password' => 'required | string',
                'device_name' => 'required | string'
            ]);
            $user = User::where('email', '=', $request->input('email'))->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are not valid']
                ]);
            }

            $user->tokens()->delete();
            $token = $user->createToken($request->device_name)->plainTextToken;
            return response()->json(['data' => $token]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['token' => $token]);
    }
}
