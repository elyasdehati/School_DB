<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Training;
use App\Models\Project;
use App\Models\Province;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrainingImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            $project = Project::where('name', $row['project'] ?? null)->first();
            $province = Province::where('name', $row['province'] ?? null)->first();
            $status = Status::where('name', $row['status'] ?? null)->first();

            $training = Training::create([
                'project_id' => $project?->id,
                'province_id' => $province?->id,

                'village' => $row['village'] ?? null,
                'training_venue' => $row['venue'] ?? null,
                'training_type' => $row['type'] ?? null,
                'training_topic' => $row['topic'] ?? null,

                'training_start_date' => $row['start_date'] ?? null,
                'training_end_date' => $row['end_date'] ?? null,

                'facilitator_name' => $row['facilitator'] ?? null,
                'facilitator_position' => $row['position'] ?? null,

                'male_participants' => $row['male'] ?? null,
                'female_participants' => $row['female'] ?? null,
                'gov_participants' => $row['gov'] ?? null,

                'avg_pre_test' => $row['pre_test'] ?? null,
                'avg_post_test' => $row['post_test'] ?? null,

                'objective' => $row['objective'] ?? null,
                'remarks' => $row['remarks'] ?? null,

                'status_id' => $status?->id,
            ]);

            if (!empty($row['districts'])) {

                $districtNames = array_map('trim', explode(',', $row['districts']));

                $districtIds = \App\Models\District::whereIn('name', $districtNames)
                    ->pluck('id')
                    ->toArray();

                $training->districts()->sync($districtIds);
            }
        }
    }
}