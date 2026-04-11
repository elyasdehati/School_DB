<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
            'project_contract_no' => $request->project_contract_number,
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
}
