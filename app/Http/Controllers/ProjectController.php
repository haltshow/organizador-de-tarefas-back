<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    public function getAll() {
        $projects = Project::all();

        return response()->json(['data' => $projects]);
    }

    public function getById(string $id): JsonResponse
    {
        try {
            $project = Project::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $project]);
    }

    public function create(Request $request,): JsonResponse
    {
        try {
            $request->validate([
                'description' => 'required | string',
                'user_creator' => 'required | int'
            ]);

            $description = $request->input('description');
            $user_creator = $request->input('user_creator');

            $project = Project::create([
                'description' => $description,
                'user_creator' => $user_creator
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


        return response()->json(['data' => $project], 201);
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required',
                'description' => 'required | string',
            ]);

            $id = $request->input('id');
            $description = $request->input('description');

            $project = Project::findOrFail($id);

            $project->description = $description;
            $project->save();

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

        return response()->json(['data' => $project]);
    }
}
