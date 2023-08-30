<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getAll() {
        $projects = Project::getAll();

        return response()->json(['data' => $projects], 200);
    }

    public function create(Request $request) {
        $name = $request->input('name');
        $description = $request->input('description');
        $user_creator = $request->input('user_creator');

        $project = Project::create([
            'name' => $name,
            'description' => $description,
            'user_creator' => $user_creator
        ]);

        return response()->json(['data' => $project, 'message' => 'Project was successfully created'], 201);
    }

    public function edit(Request $request) {
        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');

        $project = Project::findOrFail($id);

        $project->name = $name;
        $project->description = $description;

        $project->save();

        return response()->json(['data' => $project, 'message' => 'Project was successfully edited'], 200);
    }

    public function delete(int $id) {

    }
}
