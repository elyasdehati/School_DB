<?php

namespace App\Imports;

use App\Models\District;
use App\Models\ProjectClass;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectTeacher;
use App\Models\Province;

class ProjectTeachersImport implements ToCollection, WithHeadingRow
{
    private $project_id;

    public $skipped = 0;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            $exists = ProjectTeacher::where('project_id', $this->project_id)
                ->where('class_id', $row['class_id'] ?? null)
                ->where('first_name', $row['first_name'] ?? null)
                ->where('last_name', $row['last_name'] ?? null)
                ->first();

            if ($exists) {
                $this->skipped++;
                continue;
            }

            $isActive = in_array(strtolower($row['is_active'] ?? ''), ['yes','1','true']) ? 1 : 0;
            $coreTraining = in_array(strtolower($row['core_training'] ?? ''), ['yes','1','true']) ? 1 : 0;
            $refresherTraining = in_array(strtolower($row['refresher_training'] ?? ''), ['yes','1','true']) ? 1 : 0;

            $yearOfBirth = $row['year_of_birth'] ?? null;
            $age = $row['age'] ?? null;

            if (!$age && $yearOfBirth) {
                $currentYear = date('Y');
                $age = $currentYear - $yearOfBirth;
            }

            // FIX: numeric safety (added)
            $yearOfBirth = is_numeric($yearOfBirth) ? (int) $yearOfBirth : null;
            $age = is_numeric($age) ? (int) $age : null;

            ProjectTeacher::create([
                'project_id' => $this->project_id,
                'serial_number' => $row['serial_number'] ?? null,
                'class_id' => $row['class_id'] ?? null,
                'province_id' => Province::where('name', $row['province'])->first()?->id,
                'district_id' => District::where('name', $row['district'])->first()?->id,
                'village' => $row['village'] ?? null,
                'first_name' => $row['first_name'] ?? null,
                'last_name' => $row['last_name'] ?? null,
                'father_name' => $row['father_name'] ?? null,

                'starting_date' => isset($row['starting_date'])
                    ? (
                        is_numeric($row['starting_date'])
                            ? Date::excelToDateTimeObject($row['starting_date'])->format('Y-m-d')
                            : $row['starting_date']
                    )
                    : null,

                'is_active' => $isActive,
                'tazkira_number' => $row['tazkira_number'] ?? null,
                'year_of_birth' => $yearOfBirth,
                'age' => $age,
                'gender' => $row['gender'] ?? null,
                'teacher_type' => $row['teacher_type'] ?? null,
                'qualification' => $row['qualification'] ?? null,
                'phone' => $row['phone'] ?? null,
                'core_training' => $coreTraining,
                'refresher_training' => $refresherTraining,
            ]);
        }
    }
}