<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{
    public function index()
    {

        $results = Project::with('type:id,name', 'technologies')->paginate(5);

        return response()->json([
            'success' => true,
            'results' => $results,
        ]);
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->first();

        $relatedProject = Project::where('slug', '!=', $slug)->orderBy('created_at', 'desc')->limit(3)->get();

        $project->relatedProjects = $relatedProject;

        if ($project) {
            return response()->json([
                'success' => true,
                'project' => $project,
            ]);
        } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Spiacente, ma non sono stati trovati progetti',
                ]);
         }
    }
}