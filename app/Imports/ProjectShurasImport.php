<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectShura;

class ProjectShurasImport implements ToCollection, WithHeadingRow
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            $shura = ProjectShura::create([
                'project_id' => $this->project_id,
                'sno' => $row['sno'] ?? null,
                'province' => $row['province'] ?? null,
                'district' => $row['district'] ?? null,
                'village' => $row['village'] ?? null,
                'shura_name' => $row['shura_name'] ?? null,

                'shura_establishment_date' => isset($row['shura_establishment_date'])
                    ? (Date::excelToDateTimeObject($row['shura_establishment_date'])->format('Y-m-d'))
                    : null,

                'status' => $row['status'] ?? 'Active',
                'status_change_date' => isset($row['status_change_date'])
                    ? (Date::excelToDateTimeObject($row['status_change_date'])->format('Y-m-d'))
                    : null,

                'status_change_reason' => $row['status_change_reason'] ?? null,
                'remarks' => $row['remarks'] ?? null,
            ]);

            // اگر کلاس‌ها هم هست
            if (!empty($row['class_ids'])) {
                $classIds = explode(',', $row['class_ids']);
                $shura->classes()->attach($classIds);
            }
        }
    }
}