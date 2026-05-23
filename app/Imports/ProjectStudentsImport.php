<?php

namespace App\Imports;

use App\Models\ProjectStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Province;
use App\Models\District;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectStudentsImport implements ToModel, WithHeadingRow
{
    private $project_id;

    public $skipped = 0;

    private $provinces;
    private $districts;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;

        $this->provinces = Province::pluck('id', 'name');
        $this->districts = District::pluck('id', 'name');
    }

    public function model(array $row)
    {

        $exists = ProjectStudent::where('project_id', $this->project_id)
            ->where('student_id', $row['student_id'] ?? null)
            ->first();

        if ($exists) {
            $this->skipped++;
            return null;
        }

        return new ProjectStudent([
            'project_id' => $this->project_id,

            'student_id' => $row['student_id'] ?? null,
            'class_id' => $row['class_id'] ?? null,

            'province_id' => $this->provinces[$row['province'] ?? ''] ?? null,
            'district_id' => $this->districts[$row['district'] ?? ''] ?? null,

            'village' => $row['village'] ?? null,
            'asas_no' => $row['asas_no'] ?? null,
            'enrollment_date' => isset($row['enrollment_date'])? Date::excelToDateTimeObject($row['enrollment_date'])->format('Y-m-d'): null,
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