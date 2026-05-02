<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectShura;

// ADD
use App\Models\Province;
use App\Models\District;
use App\Models\ProjectClass;

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
            $province = Province::where('name', $row['province'] ?? null)->first();
            $district = District::where('name', $row['district'] ?? null)->first();

            $shura = ProjectShura::create([
                'project_id' => $this->project_id,
                'sno' => $row['sno'] ?? null,
                'province_id' => $province?->id,
                'district_id' => $district?->id,
                'village' => $row['village'] ?? null,
                'shura_name' => $row['shura_name'] ?? null,
                'shura_establishment_date' => !empty($row['establishment_date'])? date('Y-m-d', strtotime($row['establishment_date'])): null,
                'status' => $row['status'] ?? 'Active',
                'status_change_date' => !empty($row['status_change_date'])
                    ? (is_numeric($row['status_change_date'])
                        ? Date::excelToDateTimeObject($row['status_change_date'])->format('Y-m-d')
                        : date('Y-m-d', strtotime($row['status_change_date'])))
                    : null,
                'status_change_reason' => $row['status_change_reason'] ?? null,
                'remarks' => $row['remarks'] ?? null,
            ]);

            if (!empty($row['classes'])) {
                $classNames = array_map('trim', explode(',', $row['classes']));
                $classIds = ProjectClass::whereIn('class_name', $classNames)->pluck('id')->toArray();
                $shura->classes()->attach($classIds);
            }
        }
    }
}