<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectTeacher;

class ProjectTeachersImport implements ToCollection, WithHeadingRow
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            ProjectTeacher::create([
                'project_id' => $this->project_id,
                'serial_number' => $row['serial_number'] ?? null,
                'cbe_list' => $row['cbe_list'] ?? null,
                'province' => $row['province'] ?? null,
                'district' => $row['district'] ?? null,
                'village' => $row['village'] ?? null,
                'first_name' => $row['first_name'] ?? null,
                'last_name' => $row['last_name'] ?? null,
                'father_name' => $row['father_name'] ?? null,

                'starting_date' => isset($row['starting_date'])
                    ? (Date::excelToDateTimeObject($row['starting_date'])->format('Y-m-d'))
                    : null,

                'is_active' => $row['is_active'] ?? 0,
                'tazkira_number' => $row['tazkira_number'] ?? null,
                'year_of_birth' => $row['year_of_birth'] ?? null,
                'gender' => $row['gender'] ?? null,
                'teacher_type' => $row['teacher_type'] ?? null,
                'qualification' => $row['qualification'] ?? null,
                'phone' => $row['phone'] ?? null,
                'core_training' => $row['core_training'] ?? 0,
                'refresher_training' => $row['refresher_training'] ?? 0,
            ]);
        }
    }
}