<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {

        $results = Project::with('type:id,name', 'type.projects', 'technologies', 'user')->paginate(5);

        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }
}
