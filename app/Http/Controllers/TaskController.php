<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getAll() {
        $tasks = Task::getAll();

        return response()->json(['data' => $tasks], 200);
    }

    public function create(Request $request) {
        $title = $request->input('title');
        $description = $request->input('description');
        $user_id = $request->input('user_id');
        $status_id = $request->input('status_id');

        $task = Task::create([
            'name' => $title,
            'description' => $description,
            'user_id' => $user_id,
            'status_id' => $status_id
        ]);

        return response()->json(['data' => $task, 'message' => 'Task was successfully created'], 201);
    }

    public function edit(Request $request) {
        $id = $request->input('id');
        $title = $request->input('tile');
        $description = $request->input('description');
        $status_id = $request->input('status_id');

        $task = Task::findOrFail($id);

        $task->title = $title;
        $task->description = $description;
        $task->status_id = $status_id;

        $task->save();

        return response()->json(['data' => $task, 'message' => 'Task was successfully edited'], 200);
    }

    public function delete(int $id) {

    }
}
