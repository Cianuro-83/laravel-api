<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{
    public function index()
    {

        $results = Project::with('type:id,name', 'type.projects', 'technologies')->paginate(5);

        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            return response()->json([
                'success' => true,
                'project' => $project,
            ]);
        } else {
            if ($project) {
                return response()->json([
                    'success' => false,
                    'error' => 'Spiacente, ma non sono stati trovati progetti',
                ]);
            }
         }
    }
}