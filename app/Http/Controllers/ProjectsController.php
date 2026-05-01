<?php

namespace App\Http\Controllers;

use App\Imports\ProjectClassesImport;
use App\Imports\ProjectShurasImport;
use App\Models\Project;
use App\Models\ProjectClass;
use App\Models\ProjectShura;
use App\Models\ProjectStudent;
use App\Models\ProjectTeacher;
use App\Models\ShuraMember;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjectStudentsImport;
use App\Imports\ProjectTeachersImport;
use App\Imports\ShuraMembersImport;
use App\Models\Province;

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
        $provinces = Province::with('districts')->get();
        return view('admin.pages.projects.edit_projects', compact('project', 'provinces'));
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

        $lastTeacher = ProjectTeacher::latest()->first();
        $nextNumber = $lastTeacher ? $lastTeacher->id + 1 : 1;
        $nextSerial = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.pages.projects.teachers.all_teachers',compact('project', 'teachers', 'nextSerial'));
    }

    public function StoreProjectTeacher(Request $request, $id){
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        $lastTeacher = ProjectTeacher::latest()->first();
        $nextNumber = $lastTeacher ? $lastTeacher->id + 1 : 1;
        $serialNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        ProjectTeacher::create([
            'project_id' => $id,
            'serial_number' => $request->serial_number ?: $serialNumber,
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

    // Excel 
    public function ImportProjectTeachers(Request $request, $id){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProjectTeachersImport($id), $request->file('excel_file'));

        return back()->with('success', 'Teachers imported successfully');
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

        // --------------- All Project Classes ---------------
    public function AllProjectsClass($id){
        $project = Project::findOrFail($id);
        $class = ProjectClass::where('project_id', $id)->get();

        $lastClass = ProjectClass::latest()->first();
        $nextNumber = $lastClass ? $lastClass->id + 1 : 1;
        $nextClassId = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.pages.projects.classes.all_classes', compact('project', 'class', 'nextClassId'));
    }

    public function StoreProjectClass(Request $request, $id){

        $lastClass = ProjectClass::latest()->first();
        $nextNumber = $lastClass ? $lastClass->id + 1 : 1;
        $classId = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        ProjectClass::create([
            'project_id' => $id,
            'registration_date' => $request->registration_date,
            'class_id' => $request->class_id ?: $classId,
            'class_name' => $request->class_name,
            'grades' => $request->grades ? json_encode($request->grades) : null,
            'class_type' => $request->class_type,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'climate' => $request->climate,
            'infrastructure' => $request->infrastructure,
            'boys_enrolled' => $request->boys_enrolled,
            'girls_enrolled' => $request->girls_enrolled,
            'total_enrolled' => $request->total_enrolled,
            'demographic' => $request->demographic,
            'language' => $request->language,
            'class_status' => $request->class_status,
            'establishment_date' => $request->establishment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'shift' => $request->shift,
            'is_cluster' => $request->is_cluster ?? 0,
            'female_teachers' => $request->female_teachers,
            'male_teachers' => $request->male_teachers,
            'cbe_teachers' => $request->cbe_teachers,
            'is_closed' => $request->is_closed ?? 0,
            'closure_date' => $request->closure_date,
            'closure_reason' => $request->closure_reason,
            'female_sms_members' => $request->female_sms_members,
            'male_sms_members' => $request->male_sms_members,
            'sms_members' => $request->sms_members,
            'has_hub_school' => $request->has_hub_school ?? 0,
            'hub_school_name' => $request->hub_school_name,
            'hub_distance_km' => $request->hub_distance_km,
            'sip_completed' => $request->sip_completed ?? 0,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Class added successfully');
    }

    public function ImportProjectClasses(Request $request, $id){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);
        Excel::import(new ProjectClassesImport($id), $request->file('excel_file'));
        return back()->with('success', 'Classes imported successfully');
    }

    public function UpdateProjectClass(Request $request, $id){
        $class = ProjectClass::findOrFail($id);

        $class->update([
            'registration_date' => $request->registration_date,
            'class_id' => $request->class_id,
            'class_name' => $request->class_name,
            'grades' => $request->grades,
            'class_type' => $request->class_type,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'climate' => $request->climate,
            'infrastructure' => $request->infrastructure,
            'boys_enrolled' => $request->boys_enrolled,
            'girls_enrolled' => $request->girls_enrolled,
            'total_enrolled' => $request->total_enrolled,
            'demographic' => $request->demographic,
            'language' => $request->language,
            'class_status' => $request->class_status ?? 0,
            'establishment_date' => $request->establishment_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'shift' => $request->shift,
            'is_cluster' => $request->is_cluster ?? 0,
            'female_teachers' => $request->female_teachers,
            'male_teachers' => $request->male_teachers,
            'cbe_teachers' => $request->cbe_teachers,
            'is_closed' => $request->is_closed ?? 0,
            'closure_date' => $request->closure_date,
            'closure_reason' => $request->closure_reason,
            'female_sms_members' => $request->female_sms_members,
            'male_sms_members' => $request->male_sms_members,
            'sms_members' => $request->sms_members,
            'has_hub_school' => $request->has_hub_school ?? 0,
            'hub_school_name' => $request->hub_school_name,
            'hub_distance_km' => $request->hub_distance_km,
            'sip_completed' => $request->sip_completed ?? 0,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Class updated successfully');
    }

    public function DeleteProjectClass($id){
        $class = ProjectClass::findOrFail($id);
        $class->delete();

        return back()->with('success','Deleted successfully');
    }

    // --------------- All Project Students ---------------
    public function AllProjectsStudents($id){
        $project = Project::findOrFail($id);
        $classes = ProjectClass::where('project_id', $id)->get();
        $std = ProjectStudent::with('class')->where('project_id', $id)->get();

        $lastStudent = ProjectStudent::latest()->first();
        $nextNumber = $lastStudent ? $lastStudent->id + 1 : 1;
        $nextStudentId = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('admin.pages.projects.students.all_students', compact('project', 'classes', 'std', 'nextStudentId'));
    }

    public function StoreProjectStudents(Request $request, $id){
        $lastStudent = ProjectStudent::latest()->first();
        $nextNumber = $lastStudent ? $lastStudent->id + 1 : 1;
        $studentId = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        ProjectStudent::create([
            'student_id' => $request->student_id ?: $studentId,
            'project_id' => $request->project_id,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'class_id' => $request->class_id,
            'asas_no' => $request->asas_no,
            'enrollment_date' => $request->enrollment_date,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'tazkira_no' => $request->tazkira_no,
            'year_of_birth' => $request->year_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'native_language' => $request->native_language,
            'residence_type' => $request->residence_type,
            'is_disabled' => $request->is_disabled,
            'disability_type' => $request->disability_type,
            'guardian_phone' => $request->guardian_phone,
            'guardian_relation' => $request->guardian_relation,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success','Student Added Successfully');
    }

    public function ImportProjectStudents(Request $request, $id){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProjectStudentsImport($id), $request->file('excel_file'));

        return redirect()->back()->with('success', 'Students imported successfully');
    }

    public function UpdateProjectStudents(Request $request, $id){
        $student = ProjectStudent::findOrFail($id);

        $student->update([
            'student_id' => $request->student_id ?: $student->student_id,
            'project_id' => $request->project_id,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'class_id' => $request->class_id,
            'asas_no' => $request->asas_no,
            'enrollment_date' => $request->enrollment_date,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'tazkira_no' => $request->tazkira_no,
            'year_of_birth' => $request->year_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'native_language' => $request->native_language,
            'residence_type' => $request->residence_type,
            'is_disabled' => $request->is_disabled,
            'disability_type' => $request->disability_type,
            'guardian_phone' => $request->guardian_phone,
            'guardian_relation' => $request->guardian_relation,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'Student Updated Successfully');
    }

    public function DeleteProjectStudents($id){
        ProjectStudent::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Student deleted successfully');
    }
    // --------------- All Project Shura ---------------
    public function AllProjectsShura($id){
        $project = Project::findOrFail($id);
        $classes = ProjectClass::where('project_id', $id)->get();
        $shura = ProjectShura::with('classes')->where('project_id', $id)->get();

        $lastShura = ProjectShura::latest('id')->first();
        $nextSno = $lastShura ? str_pad(((int)$lastShura->sno) + 1, 3, '0', STR_PAD_LEFT) : '001';

        return view('admin.pages.projects.shura.all_shura', compact('project','classes','shura','nextSno'));
    }

    public function StoreProjectShura(Request $request, $id){
        $shura = ProjectShura::create([
            'project_id' => $id,
            'sno' => $request->sno,
            'shura_name' => $request->shura_name,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'shura_establishment_date' => $request->shura_establishment_date,
            'status' => $request->status,
            'status_change_date' => $request->status_change_date,
            'status_change_reason' => $request->status_change_reason,
            'remarks' => $request->remarks,
        ]);

        if ($request->class_ids) {
            $shura->classes()->attach($request->class_ids);
        }

        return back()->with('success', 'Shura created successfully');
    }

    public function ImportProjectShura(Request $request, $id){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ProjectShurasImport($id), $request->file('excel_file'));

        return back()->with('success', 'Shura imported successfully');
    }

    public function UpdateProjectShura(Request $request, $id){
        $shura = ProjectShura::findOrFail($id);

        $shura->update([
            'sno' => $request->sno,
            'shura_name' => $request->shura_name,
            'province' => $request->province,
            'district' => $request->district,
            'village' => $request->village,
            'shura_establishment_date' => $request->shura_establishment_date,
            'status' => $request->status,
            'status_change_date' => $request->status_change_date,
            'status_change_reason' => $request->status_change_reason,
            'remarks' => $request->remarks,
        ]);

        $shura->classes()->sync($request->class_ids ?? []);

        return back()->with('success', 'Shura updated successfully');
    }

    public function DeleteProjectShura($id){
        $shura = ProjectShura::findOrFail($id);
        $shura->classes()->detach();
        $shura->delete();

        return back()->with('success', 'Shura deleted successfully');
    }

    // --------------- All Project Shura ---------------
    public function AllProjectsShuraMembers($id){
        $project = Project::findOrFail($id);
        $shura = ProjectShura::where('project_id', $id)->get();
        $members = ShuraMember::whereIn('shura_id', $shura->pluck('id'))->get();

        return view('admin.pages.projects.shura_members.all_members', compact('project','shura','members'));
    }

    public function StoreProjectShuraMembers(Request $request, $id){
        ShuraMember::create([
            'project_id' => $id,
            'shura_id' => $request->shura_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'tazkira_no' => $request->tazkira_no,
            'year_of_birth' => $request->year_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'education_level' => $request->education_level,
            'language' => $request->language,
            'residence_type' => $request->residence_type,
            'is_disabled' => $request->is_disabled,
            'disability_type' => $request->disability_type,
            'role' => $request->role,
            'phone' => $request->phone,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Member added successfully');
    }

    public function ImportProjectShuraMembers(Request $request, $id){
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ShuraMembersImport($id), $request->file('excel_file'));

        return back()->with('success', 'Members imported successfully');
    }

    public function UpdateProjectShuraMembers(Request $request, $id){
        $member = ShuraMember::findOrFail($id);

        $member->update([
            'shura_id' => $request->shura_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'father_name' => $request->father_name,
            'tazkira_no' => $request->tazkira_no,
            'year_of_birth' => $request->year_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'education_level' => $request->education_level,
            'language' => $request->language,
            'residence_type' => $request->residence_type,
            'is_disabled' => $request->is_disabled,
            'disability_type' => $request->disability_type,
            'role' => $request->role,
            'phone' => $request->phone,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Member updated successfully');
    }

    public function DeleteProjectShuraMembers($id)    {
        $member = ShuraMember::findOrFail($id);
        $member->delete();

        return back()->with('success', 'Member deleted successfully');
    }

}
