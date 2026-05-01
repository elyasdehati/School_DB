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

            // اضافه
            $province = Province::where('name', $row['province'] ?? null)->first();
            $district = District::where('name', $row['district'] ?? null)->first();

            ProjectClass::create([
                'project_id' => $this->project_id,
                'registration_date' => isset($row['registration_date'])
                    ? (Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d'))
                    : null,
                'class_id' => $row['class_id'] ?? null,
                'class_name' => $row['class_name'] ?? null,
                'grades' => $row['grades'] ?? null,
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
                'total_enrolled' => $row['total_enrolled'] ?? null,
                'demographic' => $row['demographic'] ?? null,
                'language' => $row['language'] ?? null,
                'class_status' => strtolower($row['class_status'] ?? '') == 'active' ? 1 : 0,
                'establishment_date' => $row['establishment_date'] ?? null,
                'start_time' => $row['start_time'] ?? null,
                'end_time' => $row['end_time'] ?? null,
                'shift' => $row['shift'] ?? null,
                'is_cluster' => strtolower($row['is_cluster'] ?? '') == 'yes' ? 1 : 0,
                'female_teachers' => $row['female_teachers'] ?? null,
                'male_teachers' => $row['male_teachers'] ?? null,
                'cbe_teachers' => $row['cbe_teachers'] ?? null,
                'is_closed' => strtolower($row['is_closed'] ?? '') == 'yes' ? 1 : 0,
                'closure_date' => $row['closure_date'] ?? null,
                'closure_reason' => $row['closure_reason'] ?? null,
                'female_sms_members' => $row['female_sms_members'] ?? null,
                'male_sms_members' => $row['male_sms_members'] ?? null,
                'sms_members' => $row['sms_members'] ?? null,
                'has_hub_school' => strtolower($row['has_hub_school'] ?? '') == 'yes' ? 1 : 0,
                'hub_school_name' => $row['hub_school_name'] ?? null,
                'hub_distance_km' => $row['hub_distance_km'] ?? null,
                'sip_completed' => strtolower($row['sip_completed'] ?? '') == 'yes' ? 1 : 0,
                'remarks' => $row['remarks'] ?? null,
            ]);
        }
    }
}