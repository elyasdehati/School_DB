<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectStudent;
use App\Models\ProjectTeacher;
use App\Models\ProjectClass;
use App\Models\ProjectShura;
use App\Models\ShuraMember;
use App\Models\Training;
use App\Models\TrainingParticipant;

class BeneficiaryController extends Controller
{
    public function AllBeneficiary(){
        $projects = Project::orderBy('name')->get();
        return view('admin.pages.beneficiary.all_beneficiary', compact('projects'));
    }

    public function projectData(Request $request){
        $projectId = $request->project_id;

        $students = ProjectStudent::query();
        $teachers = ProjectTeacher::query();
        $classes  = ProjectClass::query();
        $sms      = ShuraMember::query();

        if ($projectId) {
            $students->where('project_id', $projectId);
            $teachers->where('project_id', $projectId);
            $classes->where('project_id', $projectId);
            $sms->where('project_id', $projectId);
        }

        $classTypes = (clone $classes)
            ->selectRaw('class_type, COUNT(*) as total')
            ->groupBy('class_type')
            ->get();

        $teachersByClassType = ProjectTeacher::query()
            ->join('project_classes', 'project_teachers.class_id', '=', 'project_classes.class_id')
            ->when($projectId, function ($q) use ($projectId) {
                $q->where('project_teachers.project_id', $projectId);
            })
            ->selectRaw("
                project_classes.class_type,
                SUM(CASE WHEN project_teachers.gender='Male' THEN 1 ELSE 0 END) as male,
                SUM(CASE WHEN project_teachers.gender='Female' THEN 1 ELSE 0 END) as female
            ")
            ->groupBy('project_classes.class_type')
            ->get();

        $studentsByClassType = ProjectStudent::query()
            ->join('project_classes', 'project_students.class_id', '=', 'project_classes.class_id')
            ->when($projectId, function ($q) use ($projectId) {
                $q->where('project_students.project_id', $projectId);
            })
            ->selectRaw("
                project_classes.class_type,
                SUM(CASE WHEN project_students.gender='Boy' THEN 1 ELSE 0 END) as boys,
                SUM(CASE WHEN project_students.gender='Girl' THEN 1 ELSE 0 END) as girls
            ")
            ->groupBy('project_classes.class_type')
            ->get();

        return response()->json([

            'students' => [
                'boys' => (clone $students)->where('gender', 'Boy')->count(),
                'girls' => (clone $students)->where('gender', 'Girl')->count(),
            ],

            'teachers' => [
                'male' => (clone $teachers)->where('gender', 'Male')->count(),
                'female' => (clone $teachers)->where('gender', 'Female')->count(),
            ],

            'class_types' => $classTypes,
            'teachers_by_class_type' => $teachersByClassType,
            'students_by_class_type' => $studentsByClassType,
            'sms_members' => [
                'male' => (clone $sms)->where('gender', 'Male')->count(),
                'female' => (clone $sms)->where('gender', 'Female')->count(),
            ],

        ]);
    }

    // public function AllBeneficiarySummary(){
    //     $projects = Project::withCount([
    //         'teachers',
    //         'students',
    //         'shuraMembers',
    //         'shuras',
    //         'trainings',
    //         'trainingParticipants',
    //     ])->get();

    //     foreach ($projects as $project) {

    //         // Students
    //         $project->boys_students = ProjectStudent::where('project_id', $project->id)
    //             ->where('gender', 'Boy')
    //             ->count();

    //         $project->girls_students = ProjectStudent::where('project_id', $project->id)
    //             ->where('gender', 'Girl')
    //             ->count();

    //         // Teachers
    //         $project->male_teachers = ProjectTeacher::where('project_id', $project->id)
    //             ->where('gender', 'Male')
    //             ->count();

    //         $project->female_teachers = ProjectTeacher::where('project_id', $project->id)
    //             ->where('gender', 'Female')
    //             ->count();

    //         // Shura Members
    //         $project->male_shura_members = ShuraMember::where('project_id', $project->id)
    //             ->where('gender', 'Male')
    //             ->count();

    //         $project->female_shura_members = ShuraMember::where('project_id', $project->id)
    //             ->where('gender', 'Female')
    //             ->count();
    //     }

    //     $projectsCount = Project::count();
    //     $teachersCount = ProjectTeacher::count();
    //     $studentsCount = ProjectStudent::count();
    //     $shurasCount = ProjectShura::count();
    //     $shuraMembersCount = ShuraMember::count();
    //     $trainingsCount = Training::count();
    //     $trainingParticipantsCount = TrainingParticipant::count();

    //     return view(
    //         'admin.pages.projects.ben_summary.all_summary',
    //         compact(
    //             'projects',
    //             'projectsCount',
    //             'teachersCount',
    //             'studentsCount',
    //             'shurasCount',
    //             'shuraMembersCount',
    //             'trainingsCount',
    //             'trainingParticipantsCount'
    //         )
    //     );
    // }
    public function ProjectBeneficiarySummary(Project $project){
        $classes = ProjectClass::with(['province', 'district'])
            ->where('project_id', $project->id)
            ->orderBy('province_id')
            ->orderBy('district_id')
            ->get();

        $reportData = [];

        foreach ($classes->groupBy('province_id') as $provinceId => $provinceClasses) {

            $provinceName = optional($provinceClasses->first()->province)->name ?? 'N/A';

            foreach ($provinceClasses->groupBy('district_id') as $districtId => $districtClasses) {

                $districtName = optional($districtClasses->first()->district)->name ?? 'N/A';

                // کلاس‌ها
                $totalClasses = $districtClasses->count();

                // Students (No Disability)
                $boysNoDisability = ProjectStudent::where('project_id', $project->id)
                    ->where('district_id', $districtId)
                    ->where('gender', 'Boy')
                    ->where('is_disabled', 0)
                    ->count();

                $girlsNoDisability = ProjectStudent::where('project_id', $project->id)
                    ->where('district_id', $districtId)
                    ->where('gender', 'Girl')
                    ->where('is_disabled', 0)
                    ->count();

                // Students (Disability)
                $boysDisability = ProjectStudent::where('project_id', $project->id)
                    ->where('district_id', $districtId)
                    ->where('gender', 'Boy')
                    ->where('is_disabled', 1)
                    ->count();

                $girlsDisability = ProjectStudent::where('project_id', $project->id)
                    ->where('district_id', $districtId)
                    ->where('gender', 'Girl')
                    ->where('is_disabled', 1)
                    ->count();

                // Teachers
                $maleTeachers = ProjectTeacher::where('project_id', $project->id)
                    ->where('class_id', $districtClasses->pluck('id'))
                    ->where('gender', 'Male')
                    ->count();

                $femaleTeachers = ProjectTeacher::where('project_id', $project->id)
                    ->where('class_id', $districtClasses->pluck('id'))
                    ->where('gender', 'Female')
                    ->count();

                // Shuras (SMS)
                $totalSms = ProjectShura::where('project_id', $project->id)
                    ->where('district_id', $districtId)
                    ->count();

                // Shura Members 
                $shuraIds = ProjectShura::where('project_id', $project->id)
                    ->where('district_id', $districtId)
                    ->pluck('id');

                $maleSmsMembers = ShuraMember::where('project_id', $project->id)
                    ->where('gender', 'Male')
                    ->whereIn('shura_id', $shuraIds)
                    ->count();

                $femaleSmsMembers = ShuraMember::where('project_id', $project->id)
                    ->where('gender', 'Female')
                    ->whereIn('shura_id', $shuraIds)
                    ->count();

                $reportData[] = [
                    'province' => $provinceName,
                    'district' => $districtName,

                    'total_classes' => $totalClasses,

                    'boys_no_disability' => $boysNoDisability,
                    'girls_no_disability' => $girlsNoDisability,

                    'boys_disability' => $boysDisability,
                    'girls_disability' => $girlsDisability,

                    'male_teachers' => $maleTeachers,
                    'female_teachers' => $femaleTeachers,

                    'total_sms' => $totalSms,
                    'male_sms_members' => $maleSmsMembers,
                    'female_sms_members' => $femaleSmsMembers,
                ];
            }
        }

        return view(
            'admin.pages.projects.ben_summary.all_summary',
            compact('project', 'reportData')
        );
    }
}