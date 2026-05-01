<?php

namespace App\Imports;

use App\Models\ProjectStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Province;
use App\Models\District;

class ProjectStudentsImport implements ToModel, WithHeadingRow
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function model(array $row)
    {
        $province = Province::where('name', $row['province'] ?? null)->first();
        $district = District::where('name', $row['district'] ?? null)->first();

        return new ProjectStudent([
            'project_id' => $this->project_id,

            'student_id' => $row['student_id'] ?? null,
            'class_id' => $row['class_id'] ?? null,
            'province_id' => $province?->id,
            'district_id' => $district?->id,
            'village' => $row['village'] ?? null,
            'asas_no' => $row['asas_no'] ?? null,
            'enrollment_date' => $row['enrollment_date'] ?? null,
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'father_name' => $row['father_name'] ?? null,
            'tazkira_no' => $row['tazkira_no'] ?? null,
            'year_of_birth' => $row['year_of_birth'] ?? null,
            'age' => $row['age'] ?? null,
            'gender' => $row['gender'] ?? null,
            'native_language' => $row['native_language'] ?? null,
            'residence_type' => $row['residence_type'] ?? null,
            'is_disabled' => strtolower($row['is_disabled'] ?? '') == 'yes' ? 1 : 0,
            'disability_type' => $row['disability_type'] ?? null,
            'guardian_phone' => $row['guardian_phone'] ?? null,
            'guardian_relation' => $row['guardian_relation'] ?? null,
            'status' => $row['status'] ?? 'Active',
            'remarks' => $row['remarks'] ?? null,
        ]);
    }
}