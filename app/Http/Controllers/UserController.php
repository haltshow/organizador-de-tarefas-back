<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::all();

        return response()->json(['data' => $users], 200);
    }

    public function getById(string $id) {
        try {
            $user = User::findOrFail($id);
        } catch(ModelNotFoundException $e) {
            throw UserException::userNotFound();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $user], 200);
    }

    public function create(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password')
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $user], 201);
    }

}
