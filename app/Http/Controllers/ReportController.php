<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function create($id)
    {
        $project = Project::find($id);
        return view('Report.index', compact('project'));
    }
}
