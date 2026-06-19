<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectClass;
use App\Models\ProjectStudent;
use App\Models\ProjectTeacher;
use App\Models\ProjectShura;
use App\Models\ShuraMember;

class BeneficiarySummaryController extends Controller
{
    public function AllBeneficiarySummary()
    {
        $classes = ProjectClass::with(['project', 'province', 'district'])
            ->orderBy('project_id')
            ->orderBy('province_id')
            ->orderBy('district_id')
            ->get();

        $reportData = [];

        foreach ($classes->groupBy('project_id') as $projectId => $projectGroups) {

            $projectName = optional($projectGroups->first()->project)->name ?? 'N/A';

            foreach ($projectGroups->groupBy('province_id') as $provinceId => $provinceGroups) {

                $provinceName = optional($provinceGroups->first()->province)->name ?? 'N/A';

                foreach ($provinceGroups->groupBy('district_id') as $districtId => $districtGroups) {

                    $districtName = optional($districtGroups->first()->district)->name ?? 'N/A';

                    $totalClasses = $districtGroups->count();

                    // Students
                    $boysNoDisability = ProjectStudent::where('project_id', $projectId)
                        ->where('district_id', $districtId)
                        ->where('gender', 'Boy')
                        ->where('is_disabled', 0)
                        ->count();

                    $girlsNoDisability = ProjectStudent::where('project_id', $projectId)
                        ->where('district_id', $districtId)
                        ->where('gender', 'Girl')
                        ->where('is_disabled', 0)
                        ->count();

                    $boysDisability = ProjectStudent::where('project_id', $projectId)
                        ->where('district_id', $districtId)
                        ->where('gender', 'Boy')
                        ->where('is_disabled', 1)
                        ->count();

                    $girlsDisability = ProjectStudent::where('project_id', $projectId)
                        ->where('district_id', $districtId)
                        ->where('gender', 'Girl')
                        ->where('is_disabled', 1)
                        ->count();

                    // Teachers
                    $maleTeachers = ProjectTeacher::where('project_id', $projectId)
                        ->whereIn('class_id', $districtGroups->pluck('id'))
                        ->where('gender', 'Male')
                        ->count();

                    $femaleTeachers = ProjectTeacher::where('project_id', $projectId)
                        ->whereIn('class_id', $districtGroups->pluck('id'))
                        ->where('gender', 'Female')
                        ->count();

                    // Shura
                    $totalSms = ProjectShura::where('project_id', $projectId)
                        ->where('district_id', $districtId)
                        ->count();

                    $shuraIds = ProjectShura::where('project_id', $projectId)
                        ->where('district_id', $districtId)
                        ->pluck('id');

                    $maleSmsMembers = ShuraMember::where('project_id', $projectId)
                        ->where('gender', 'Male')
                        ->whereIn('shura_id', $shuraIds)
                        ->count();

                    $femaleSmsMembers = ShuraMember::where('project_id', $projectId)
                        ->where('gender', 'Female')
                        ->whereIn('shura_id', $shuraIds)
                        ->count();

                    $reportData[] = [
                        'project_id' => $projectId,
                        'project' => $projectName,

                        'province_id' => $provinceId,
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
        }

        return view('admin.pages.ben_summary.all_summary', compact('reportData'));
    }
}