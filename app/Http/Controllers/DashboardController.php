<?php

namespace App\Http\Controllers;
use App\Models\ProjectClass;
use App\Models\ProjectTeacher;
use App\Models\ProjectStudent;
use App\Models\ProjectShura;
use App\Models\ShuraMember;
use App\Models\Training;
use App\Models\TrainingParticipant;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $classes = ProjectClass::count();

        $teachers = ProjectTeacher::where('is_active', 1)->get();
        // $maleTeachers = $teachers->where('gender', 'Male')->count();
        // $femaleTeachers = $teachers->where('gender', 'Female')->count();
        $totalTeachers = $teachers->count();

        $students = ProjectStudent::whereHas('statuses', function ($q) {
            $q->where('name', 'Active');
        })->get();
        // $maleStudents = $students->where('gender', 'Boy')->count();
        // $femaleStudents = $students->where('gender', 'Girl')->count();
        $totalStudents = $students->count();

        $shura = ProjectShura::whereHas('status', function ($q) {
            $q->where('name', 'Active');
        })->count();

        $shuraMembers = ShuraMember::where('status', 1)->get();
        // $maleShura = $shuraMembers->where('gender', 'Male')->count();
        // $femaleShura = $shuraMembers->where('gender', 'Female')->count();
        $totalShuraMembers = $shuraMembers->count();

        $trainings = Training::whereHas('status', function ($q) {
            $q->where('name', 'Active');
        })->count();

        $participants = TrainingParticipant::get();
        // $maleParticipants = $participants->where('gender', 'Male')->count();
        // $femaleParticipants = $participants->where('gender', 'Female')->count();
        $totalParticipants = $participants->count();

        // chart data
        $projects = \App\Models\Project::withCount([
            'teachers',
            'students',
            'shuraMembers'
        ])->get();

        $chartLabels = $projects->pluck('name');

        $chartData = $projects->map(function($project){
            return $project->teachers_count
                + $project->students_count
                + $project->shura_members_count;
        });

        return view('admin.index', compact(
            'classes','totalTeachers','totalStudents',
            'shura','totalShuraMembers', 'trainings', 'totalParticipants',
            'chartLabels','chartData'
        ));
    }
}
