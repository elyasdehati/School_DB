<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function AllTraining($id){
        $project = Project::findOrFail($id);
        $train = Training::where('project_id', $id)->get();

        return view('admin.pages.projects.training.all_training', compact('project', 'train'));
    }
}
