<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ShuraMember;

class ShuraMembersImport implements ToCollection, WithHeadingRow
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            ShuraMember::create([
                'project_id' => $this->project_id,
                'shura_id' => $row['shura_id'] ?? null,
                'first_name' => $row['first_name'] ?? null,
                'last_name' => $row['last_name'] ?? null,
                'father_name' => $row['father_name'] ?? null,
                'tazkira_no' => $row['tazkira_no'] ?? null,
                'year_of_birth' => $row['year_of_birth'] ?? null,
                'age' => $row['age'] ?? null,
                'gender' => $row['gender'] ?? null,
                'education_level' => $row['education_level'] ?? null,
                'language' => $row['language'] ?? null,
                'residence_type' => $row['residence_type'] ?? null,
                'is_disabled' => $row['is_disabled'] ?? 0,
                'disability_type' => $row['disability_type'] ?? null,
                'role' => $row['role'] ?? null,
                'phone' => $row['phone'] ?? null,
                'status' => $row['status'] ?? 1,
                'remarks' => $row['remarks'] ?? null,
            ]);
        }
    }
}