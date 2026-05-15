<?php

namespace App\Http\Controllers;

use App\Exports\TrainingExport;
use App\Imports\TrainingImport;
use App\Models\District;
use App\Models\Project;
use App\Models\Province;
use App\Models\Status;
use App\Models\Training;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        if ($request->district_ids) {
            $training->districts()->sync($request->district_ids);
        }

        return redirect()->back()->with('success', 'Training created successfully');
    }

    public function UpdateProjectTraining(Request $request, $id){
        $training = Training::findOrFail($id);

        $training->update([
            'project_id' => $request->project_id,
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

        if ($request->district_ids) {
            $training->districts()->sync($request->district_ids ?? []);
        }

        return redirect()->back()->with('success', 'Training updated successfully');
    }

    public function ExportProjectTraining($project_id, $type){
        $withData = $type === 'data';

        return Excel::download(
            new TrainingExport($project_id, $withData),
            $withData ? 'Training_with_data.xlsx' : 'Training_template.xlsx'
        );
    }

    public function ImportProjectTraining(Request $request, $id){
        $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls'
            ]);
        Excel::import(new TrainingImport($id), $request->file('excel_file'));

        return back()->with('success', 'Imported successfully');
    }

    public function DeleteProjectTraining($id){
        $training = Training::findOrFail($id);
        $training->districts()->detach();
        $training->delete();

        return redirect()->back()->with('success', 'Training deleted successfully');
    }
}
