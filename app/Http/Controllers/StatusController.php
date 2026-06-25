<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;

class StatusController extends Controller
{
    public function AllStatus(){
        $status = Status::all();
        return view('admin.pages.status.all_status', compact('status'));
    }

    public function AddStatus(){
        return view('admin.pages.status.add_status');
    }

    public function StoreStatus(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        Status::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        ActivityLogger::log(
            'create_status',
            'Status created: ' . $request->name
        );

        return redirect()->route('all.status');
    }

    public function EditStatus($id){
        $status = Status::findOrFail($id);
        return view('admin.pages.status.edit_status', compact('status'));
    }

    public function UpdateStatus(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        $status = Status::findOrFail($id);
        $status->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        ActivityLogger::log(
            'update_status',
            'Status updated ID: ' . $id
        );

        return redirect()->route('all.status');
    }

    public function DeleteStatus($id){
        $status = Status::findOrFail($id);

        ActivityLogger::log(
            'delete_status',
            'Status deleted ID: ' . $id
        );

        $status->delete();

        return redirect()->route('all.status');
    }

    // ----------- Project Status ----------
    public function AllProjectStatus(){
        $pstatus = ProjectStatus::all();
        return view('admin.pages.projectstatus.all_project_status', compact('pstatus'));
    }

    public function AddProjectStatus(){
        return view('admin.pages.projectstatus.add_project_status');
    }

    public function StoreProjectStatus(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        ProjectStatus::create([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        ActivityLogger::log(
            'create_project_status',
            'Project status created: ' . $request->name
        );

        return redirect()->route('all.project.status');
    }

    public function EditProjectStatus($id){
        $status = ProjectStatus::findOrFail($id);
        return view('admin.pages.projectstatus.edit_project_status', compact('status'));
    }

    public function UpdateProjectStatus(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:20',
        ]);

        $status = ProjectStatus::findOrFail($id);
        $status->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        ActivityLogger::log(
            'update_project_status',
            'Project status updated ID: ' . $id
        );

        return redirect()->route('all.project.status');
    }

    public function DeleteProjectStatus($id){
        $status = ProjectStatus::findOrFail($id);

        ActivityLogger::log(
            'delete_project_status',
            'Project status deleted ID: ' . $id
        );

        $status->delete();

        return redirect()->route('all.project.status');
    }
}