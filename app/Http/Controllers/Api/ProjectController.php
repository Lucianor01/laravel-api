<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        // $projects = Project::all();

        $projects = Project::with('type', 'technologies')->get();

        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }
}
