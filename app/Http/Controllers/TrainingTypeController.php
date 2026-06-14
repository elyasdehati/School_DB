<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{
    public function AllTrainingType(){
        $all_types = TrainingType::all();
        return view('admin.pages.training_type.all_training', compact('all_types'));
    }

    public function AddTrainingType(){
        return view('admin.pages.training_type.add_training');
    }
}
