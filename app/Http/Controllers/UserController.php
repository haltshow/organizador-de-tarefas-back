<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json(['data' => $users]);
    }

    public function getById(string $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
        } catch(ModelNotFoundException) {
            throw UserException::userNotFound();
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $user]);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => 'required | string',
                'email' => 'required | string',
                'password' => 'required | string'
            ]);
            $name = $request->input('name');
            $email = $request->input('email');

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($request->input('password'))
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch(Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $user], 201);
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);

            $id = $request->input('id');
            $name = $request->input('name');
            $password = $request->input('password');

            $user = User::findOrFail($id);
            if ($name) $user->description = $name;
            if ($password) $user->password = Hash::make('password');
            $user->save();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $user]);
    }
}
