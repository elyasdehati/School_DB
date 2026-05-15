<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Project;
use App\Models\Province;
use App\Models\Status;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function AllTraining($id){
        $project = Project::findOrFail($id);
        $train = Training::with(['project', 'province', 'districts'])->where('project_id', $id)->get();

        $provinces = Province::all();
        $districts = District::all();
        $statuses = Status::all();

        return view('admin.pages.projects.training.all_training', compact('project', 'train', 'provinces', 'districts', 'statuses'));
    }

    public function getTrainingDistricts($province_id){
        $districts = District::where('province_id', $province_id)->get();

        return response()->json($districts);
    }

    public function StoreProjectTraining(Request $request, $project_id){
        $training = Training::create([
            'project_id' => $project_id,
            'province_id' => $request->province_id,
            'village' => $request->village,
            'training_venue' => $request->training_venue,
            'training_type' => $request->training_type,
            'training_topic' => $request->training_topic,
            'training_start_date' => $request->training_start_date,
            'training_end_date' => $request->training_end_date,
            'facilitator_name' => $request->facilitator_name,
            'facilitator_position' => $request->facilitator_position,
            'male_participants' => $request->male_participants,
            'female_participants' => $request->female_participants,
            'gov_participants' => $request->gov_participants,
            'status_id' => $request->status_id,
            'avg_pre_test' => $request->avg_pre_test,
            'avg_post_test' => $request->avg_post_test,
            'objective' => $request->objective,
            'remarks' => $request->remarks,
        ]);

        // districts relation (many-to-many)
        if ($request->district_ids) {
            $training->districts()->sync($request->district_ids);
        }

        return redirect()->back()->with('success', 'Training created successfully');
    }
}
