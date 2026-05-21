<?php

namespace App\Http\Controllers;
use App\Models\ProjectClass;
use App\Models\ProjectTeacher;
use App\Models\ProjectStudent;
use App\Models\ProjectShura;
use App\Models\ShuraMember;
use App\Models\Training;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $classes = ProjectClass::count();

        $teachers = ProjectTeacher::where('is_active', 1)->get();
        $maleTeachers = $teachers->where('gender', 'Male')->count();
        $femaleTeachers = $teachers->where('gender', 'Female')->count();
        $totalTeachers = $teachers->count();

        $students = ProjectStudent::where('status', 'Active')->get();
        $maleStudents = $students->where('gender', 'Boy')->count();
        $femaleStudents = $students->where('gender', 'Girl')->count();
        $totalStudents = $students->count();

        $shura = ProjectShura::where('status', 'Active')->count();

        $shuraMembers = ShuraMember::where('status', 1)->get();
        $maleShura = $shuraMembers->where('gender', 'Male')->count();
        $femaleShura = $shuraMembers->where('gender', 'Female')->count();
        $totalShuraMembers = $shuraMembers->count();

        $trainings = Training::whereHas('status', function ($q) {
            $q->where('name', 'Active');
        })->count();

        return view('admin.index', compact(
            'classes',
            'maleTeachers','femaleTeachers','totalTeachers',
            'maleStudents','femaleStudents','totalStudents',
            'shura',
            'maleShura','femaleShura','totalShuraMembers', 'trainings'
        ));
    }
}
