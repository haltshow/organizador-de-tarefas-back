<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StatusController extends Controller
{
    public function getAll(): JsonResponse
    {
        $status = Status::all();

        return response()->json(['data' => $status]);
    }

    public function getById(string $id): JsonResponse
    {
        try {
            $status = Status::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $status]);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'description' => 'required | string'
            ]);

            $description = $request->input('description');

            $status = Status::create([
                'description' => $description
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }


        return response()->json(['data' => $status], 201);
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required',
                'description' => 'required | string'
            ]);

            $id = $request->input('id');
            $description = $request->input('description');

            $status = Status::findOrFail($id);
            $status->description = $description;
            $status->save();
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

        return response()->json(['data' => $status]);
    }
}
