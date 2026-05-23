<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectClass;

// اضافه
use App\Models\Province;
use App\Models\District;

class ProjectClassesImport implements ToCollection, WithHeadingRow
{
    private $project_id;

    public $skipped = 0;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            if (isset($row['total_enrolled']) && is_string($row['total_enrolled']) && str_starts_with($row['total_enrolled'], '=')) {
                $row['total_enrolled'] = null;
            }

            if (isset($row['sms_members']) && is_string($row['sms_members']) && str_starts_with($row['sms_members'], '=')) {
                $row['sms_members'] = null;
            }

            $boys = (int)($row['boys_enrolled'] ?? 0);
            $girls = (int)($row['girls_enrolled'] ?? 0);
            $femaleTeachers = (int)($row['female_teachers'] ?? 0);
            $maleTeachers = (int)($row['male_teachers'] ?? 0);

            $province = Province::where('name', $row['province'] ?? null)->first();
            $district = District::where('name', $row['district'] ?? null)->first();
            $status = \App\Models\Status::where('name', $row['class_status'] ?? null)->first();

            $exists = \App\Models\ProjectClass::where('project_id', $this->project_id)
                ->where('class_id', $row['class_id'] ?? null)
                ->first();

            if ($exists) {
                $this->skipped++;
                continue;
            }

            ProjectClass::create([
                'project_id' => $this->project_id,
                
                'registration_date' => !empty($row['registration_date'])? (is_numeric($row['registration_date'])? Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d'): date('Y-m-d', strtotime($row['registration_date']))): null,
                'class_id' => $row['class_id'] ?? null,
                'class_name' => $row['class_name'] ?? null,
                'grades' => isset($row['grades'])? json_encode(array_map('trim', explode(',', $row['grades']))): null,
                'class_type' => $row['class_type'] ?? null,

                'province_id' => $province?->id,
                'district_id' => $district?->id,
                'village' => $row['village'] ?? null,
                'latitude' => $row['latitude'] ?? null,
                'longitude' => $row['longitude'] ?? null,
                'climate' => $row['climate'] ?? null,
                'infrastructure' => $row['infrastructure'] ?? null,
                'boys_enrolled' => $row['boys_enrolled'] ?? null,
                'girls_enrolled' => $row['girls_enrolled'] ?? null,

                'total_enrolled' => ($boys + $girls) ?: (is_numeric($row['total_enrolled'] ?? null) ? (int)$row['total_enrolled'] : null),

                'demographic' => $row['demographic'] ?? null,
                'language' => $row['language'] ?? null,
                'status_id' => $status?->id,
                'start_time' => !empty($row['start_time'])? date('G:i', strtotime($row['start_time'])): null,
                'end_time' => !empty($row['end_time'])? date('G:i', strtotime($row['end_time'])): null,
                'shift' => $row['shift'] ?? null,
                'is_cluster' => strtolower($row['is_cluster'] ?? '') == 'yes' ? 1 : 0,
                'female_teachers' => $row['female_teachers'] ?? null,
                'male_teachers' => $row['male_teachers'] ?? null,
                'cbe_teachers' => ((int)($row['female_teachers'] ?? 0) + (int)($row['male_teachers'] ?? 0)),
                'is_closed' => strtolower($row['is_class_closed'] ?? '') == 'yes' ? 1 : 0,
                'closure_date' => $row['closure_date'] ?? null,
                'closure_reason' => $row['closure_reason'] ?? null,
                'female_sms_members' => (int)($row['female_sms_members'] ?? 0),
                'male_sms_members' => (int)($row['male_sms_members'] ?? 0),

                'sms_members' => ((int)($row['female_sms_members'] ?? 0) + (int)($row['male_sms_members'] ?? 0)),
                'has_hub_school' => strtolower($row['has_hub_school'] ?? '') == 'yes' ? 1 : 0,
                'hub_school_name' => $row['hub_school_name'] ?? null,
                'hub_distance_km' => $row['hub_distance_km'] ?? null,
                'sip_completed' => strtolower($row['sip_completed'] ?? '') == 'yes' ? 1 : 0,
                'remarks' => $row['remarks'] ?? null,
            ]);
        }
    }
}