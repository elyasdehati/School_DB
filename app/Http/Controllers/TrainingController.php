<?php

namespace App\Http\Controllers;

use App\Exports\TrainingExport;
use App\Exports\TrainingParticipantsExport;
use App\Imports\TrainingImport;
use App\Imports\TrainingParticipantsImport;
use App\Models\District;
use App\Models\Project;
use App\Models\Province;
use App\Models\Status;
use App\Models\Training;
use App\Models\TrainingParticipant;
use App\Models\TrainingType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ActivityLogger;

class TrainingController extends Controller
{
    public function AllTraining($id){
        $project = Project::findOrFail($id);
        $train = Training::with(['project', 'province', 'districts'])->where('project_id', $id)->get();

        $provinces = Province::all();
        $districts = District::all();
        $statuses = Status::all();
        $trainingTypes = TrainingType::all();

        return view('admin.pages.projects.training.all_training', compact('project', 'train', 'provinces', 'districts', 'statuses', 'trainingTypes'));
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
            'training_type_id' => $request->training_type_id,
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

        ActivityLogger::log(
            'create_project_training',
            'Training created: ' . $request->training_topic
        );

        return redirect()->back()->with('success', 'Training created successfully');
    }

    public function UpdateProjectTraining(Request $request, $id){
        $training = Training::findOrFail($id);

        $training->update([
            'project_id' => $request->project_id,
            'province_id' => $request->province_id,
            'village' => $request->village,
            'training_venue' => $request->training_venue,
            'training_type_id' => $request->training_type_id,
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

        ActivityLogger::log(
            'update_project_training',
            'Training updated: ' . $training->training_topic
        );

        return redirect()->back()->with('success', 'Training updated successfully');
    }

    public function ExportProjectTraining($project_id, $type){
        $withData = $type === 'data';
        ActivityLogger::log(
            'export_project_training',
            'Training exported for Project ID: ' . $project_id
        );

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
        ActivityLogger::log(
            'import_project_training',
            'Training imported for Project ID: ' . $id
        );

        return back()->with('success', 'Imported successfully');
    }

    public function DeleteProjectTraining($id){
        $training = Training::findOrFail($id);
        $training->districts()->detach();
        ActivityLogger::log(
            'delete_project_training',
            'Training deleted: ' . $training->training_topic
        );
        $training->delete();

        return redirect()->back()->with('success', 'Training deleted successfully');
    }

    // ------ Training Participant -------
    public function AllTrainingParticipant($id){
        $project = Project::findOrFail($id);
        $part = TrainingParticipant::with(['project', 'training', 'province', 'district'])->where('project_id', $id)->get();
        $trainings = Training::where('project_id', $id)->get();

        $provinces = Province::all();
        $districts = District::all();

        return view('admin.pages.projects.training_participant.all_participant', compact('project', 'part', 'provinces', 'districts', 'trainings'));
    }

    public function getParticipantDistricts($province_id){
        $districts = District::where('province_id', $province_id)->get();

        return response()->json($districts);
    }

    public function StoreTrainingParticipant(Request $request, $project_id){
        TrainingParticipant::create([
            'project_id' => $project_id,
            'training_type' => $request->training_type,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'village' => $request->village,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'trainee_type' => $request->trainee_type,
            'gender' => $request->gender,
            'age' => $request->age,
            'is_disabled' => $request->is_disabled,
            'disability_type' => $request->disability_type,
            'phone' => $request->phone,
            'pre_test' => $request->pre_test,
            'post_test' => $request->post_test,
            'remarks' => $request->remarks,
        ]);

        ActivityLogger::log(
            'create_training_participant',
            'Participant created: ' . $request->first_name . ' ' . $request->last_name
        );

        return redirect()->back()->with('success', 'Participant added successfully');
    }

    public function UpdateTrainingParticipant(Request $request, $id){
        $participant = TrainingParticipant::findOrFail($id);

        $participant->update([
            'training_type' => $request->training_type,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'village' => $request->village,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'trainee_type' => $request->trainee_type,
            'gender' => $request->gender,
            'age' => $request->age,
            'is_disabled' => $request->is_disabled,
            'disability_type' => $request->disability_type,
            'phone' => $request->phone,
            'pre_test' => $request->pre_test,
            'post_test' => $request->post_test,
            'remarks' => $request->remarks,
        ]);

        ActivityLogger::log(
            'update_training_participant',
            'Participant updated: ' . $participant->first_name . ' ' . $participant->last_name
        );

        return redirect()->back()->with('success', 'Participant added successfully');
    }

    public function ExportTrainingParticipant($project_id, $type){
        $withData = $type === 'data';
        ActivityLogger::log(
            'export_training_participants',
            'Training participants exported for Project ID: ' . $project_id
        );

        return Excel::download(
            new TrainingParticipantsExport($project_id, $withData),
            $withData
                ? 'training_participants.xlsx'
                : 'training_participants_template.xlsx'
        );
    }

    public function ImportTrainingParticipant(Request $request, $id){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        $import = new TrainingParticipantsImport($id);

        Excel::import($import, $request->file('excel_file'));
        ActivityLogger::log(
            'import_training_participants',
            'Training participants imported for Project ID: ' . $id . '. Skipped: ' . $import->skipped
        );

        return back()->with(
            'success',
            'Participants imported successfully. Skipped duplicates: ' . $import->skipped
        );
    }

    public function DeleteTrainingParticipant($id){
        $participant = TrainingParticipant::findOrFail($id);
        ActivityLogger::log(
            'delete_training_participant',
            'Participant deleted: ' . $participant->first_name . ' ' . $participant->last_name
        );
        $participant->delete();

        return redirect()->back()->with('success', 'Participant added successfully');
    }
}
