<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class TrainingTypeController extends Controller
{
    public function AllTrainingType(){
        $all_types = TrainingType::all();
        return view('admin.pages.training_type.all_training', compact('all_types'));
    }

    public function AddTrainingType(){
        return view('admin.pages.training_type.add_training');
    }

    public function StoreTrainingType(Request $request){
        TrainingType::create([
            'name' => $request->name
        ]);

        ActivityLogger::log(
            'create_training_type',
            'Training type created: ' . $request->name
        );

        return redirect()->route('all.training.type');
    }

    public function EditTrainingType($id){
        $all_types = TrainingType::findOrFail($id);
        return view('admin.pages.training_type.edit_training', compact('all_types'));
    }

    public function UpdateTrainingType(Request $request, $id){
        $all_types = TrainingType::findOrFail($id);

        $all_types->update([
            'name' => $request->name
        ]);

        ActivityLogger::log(
            'update_training_type',
            'Training type updated ID: ' . $id
        );

        return redirect()->route('all.training.type');
    }

    public function DeleteTrainingType($id){
        $all_types = TrainingType::findOrFail($id);

        ActivityLogger::log(
            'delete_training_type',
            'Training type deleted ID: ' . $id
        );

        $all_types->delete();

        return redirect()->route('all.training.type');
    }
}