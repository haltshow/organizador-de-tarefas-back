<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function getAll(): JsonResponse
    {
        $tasks = Task::all();

        return response()->json(['data' => $tasks], 200);
    }

    public function getById(string $id): JsonResponse
    {
        try {
            $task = Task::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'No one task encountered'
            ], 404);
        } catch (Exception) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        return response()->json(['data' => $task]);
    }

    public function create(Request $request,): JsonResponse
    {
        try {
            $request->validate([
                'title' => 'required | string',
                'description' => 'required | string',
                'user_id' => 'required | int',
                'status_id' => 'required | int'
            ]);

            $title = $request->input('title');
            $description = $request->input('description');
            $user_id = $request->input('user_id');
            $status_id = $request->input('status_id');

            $task = Task::create([
                'title' => $title,
                'description' => $description,
                'user_id' => $user_id,
                'status_id' => $status_id
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


        return response()->json(['data' => $task], 201);
    }

    public function edit(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required',
                'title' => 'required | string',
                'description' => 'required | string',
                'status_id' => 'required | int'
            ]);

            $id = $request->input('id');
            $title = $request->input('title');
            $description = $request->input('description');
            $status_id = $request->input('status_id');

            $task = Task::findOrFail($id);

            $task->title = $title;
            $task->description = $description;
            $task->status_id = $status_id;
            $task->save();

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

        return response()->json(['data' => $task]);
    }
}
