<?php

namespace App\Http\Controllers;

use App\Models\ProjectStatus;
use App\Models\Status;
use Illuminate\Http\Request;

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

        return redirect()->route('all.status');
    }

    public function DeleteStatus($id){
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()->route('all.status');
    }

    // All Project Status
    public function AllProjectStatus(){
        $pstatus = ProjectStatus::all();
        return view('admin.pages.projectstatus.all_project_status', compact('pstatus'));
    }
    
    public function AddProjectStatus(){
        return view('admin.pages.projectstatus.add_project_status');
    }
}
