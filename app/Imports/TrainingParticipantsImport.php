<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\TrainingParticipant;
use App\Models\Province;
use App\Models\District;

class TrainingParticipantsImport implements ToCollection, WithHeadingRow
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

            $exists = TrainingParticipant::where('project_id', $this->project_id)
                ->where('first_name', $row['first_name'] ?? null)
                ->where('last_name', $row['last_name'] ?? null)
                ->where('father_name', $row['father_name'] ?? null)
                ->first();

            if ($exists) {
                $this->skipped++;
                continue;
            }

            $province = Province::where('name', $row['province'] ?? null)->first();
            $district = District::where('name', $row['district'] ?? null)->first();

            TrainingParticipant::create([
                'project_id' => $this->project_id,
                'training_type' => $row['training_type'] ?? null,
                'province_id' => $province?->id,
                'district_id' => $district?->id,
                'village' => $row['village'] ?? null,
                'first_name' => $row['first_name'] ?? null,
                'last_name' => $row['last_name'] ?? null,
                'father_name' => $row['father_name'] ?? null,
                'trainee_type' => $row['trainee_type'] ?? null,
                'gender' => $row['gender'] ?? null,
                'age' => $row['age'] ?? null,
                'is_disabled' => strtolower($row['is_disabled'] ?? '') === 'yes' ? 1 : 0,
                'disability_type' => $row['disability_type'] ?? null,
                'phone' => $row['phone'] ?? null,
                'pre_test' => $row['pre_test'] ?? null,
                'post_test' => $row['post_test'] ?? null,
                'remarks' => $row['remarks'] ?? null,
            ]);
        }
    }
}