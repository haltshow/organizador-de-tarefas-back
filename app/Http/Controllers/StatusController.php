<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function getAll() {
        $status = Status::getAll();

        return response()->json(['data' => $status], 200);
    }
}
