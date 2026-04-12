<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTeacher;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function AllProjects(){
        $project = Project::latest()->get();
        return view('admin.pages.projects.all_projects', compact('project'));
    }

    public function AddProject(){
        return view('admin.pages.projects.add_project');
    }

    public function StoreProject(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Project::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('all.projects')->with('success','Project created successfully!');
    }

    public function EditProject($id){
        $project = Project::find($id);
        return view('admin.pages.projects.edit_projects', compact('project'));
    }

    public function UpdateProject(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project_contract_no' => $request->project_contract_no,
            'donor' => $request->donnor,
            'partner' => $request->partner,
            'thematic_area' => $request->thematic_area,
            'status' => $request->status,
            'province' => json_encode($request->categories),
            'district' => json_encode($request->districts),
            'description' => $request->description,
        ]);

        return redirect()->route('all.projects')->with('success','Project updated successfully!');
    }

    public function ShowProject($id){
        $project = Project::find($id);
        return view('admin.pages.projects.show_projects', compact('project'));
    }

    public function DeleteProject($id){
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('all.projects')->with('success','Project deleted successfully!');
    }

    // --------------- All Project Teachers ---------------
    public function AllProjectsTeachers($id){
        $project = Project::findOrFail($id);
        $teachers = ProjectTeacher::where('project_id', $id)->get();
        return view('admin.pages.projects.teachers.all_teachers', compact('project', 'teachers'));
    }

    public function StoreProjectTeacher(Request $request, $id){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        ProjectTeacher::create([
            'project_id' => $id,
            'serial_number' => $request->serial_number,
            'cbe_list' => $request->cbe_list,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'starting_date' => $request->starting_date,
            'is_active' => $request->is_active ?? 0,
            'tazkira_number' => $request->tazkira_number,
            'year_of_birth' => $request->year_of_birth,
            'gender' => $request->gender,
            'teacher_type' => $request->teacher_type,
            'qualification' => $request->qualification,
            'phone' => $request->phone,
            'core_training' => $request->core_training ?? 0,
            'refresher_training' => $request->refresher_training ?? 0,
        ]);

        return redirect()->back()->with('success','Teacher added successfully');
    }

    public function UpdateProjectTeacher(Request $request, $id){
        $teacher = ProjectTeacher::findOrFail($id);
        $teacher->update([
            'serial_number' => $request->serial_number,
            'cbe_list' => $request->cbe_list,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'starting_date' => $request->starting_date,
            'is_active' => $request->is_active ?? 0,
            'tazkira_number' => $request->tazkira_number,
            'year_of_birth' => $request->year_of_birth,
            'gender' => $request->gender,
            'teacher_type' => $request->teacher_type,
            'qualification' => $request->qualification,
            'phone' => $request->phone,
            'core_training' => $request->core_training ?? 0,
            'refresher_training' => $request->refresher_training ?? 0,
        ]);

        return back()->with('success','Updated successfully');
    }

    public function DeleteProjectTeacher($id){
        $teacher = ProjectTeacher::findOrFail($id);
        $teacher->delete();

        return back()->with('success','Deleted successfully');
    }

}
