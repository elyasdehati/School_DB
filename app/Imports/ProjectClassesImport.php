<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectClass;

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

            ProjectClass::create([
                'project_id' => $this->project_id,
                'registration_date' => isset($row['registration_date'])
                    ? (Date::excelToDateTimeObject($row['registration_date'])->format('Y-m-d'))
                    : null,
                'class_id' => $row['class_id'] ?? null,
                'class_name' => $row['class_name'] ?? null,
                'grades' => $row['grades'] ?? null,
                'class_type' => $row['class_type'] ?? null,
                'province' => $row['province'] ?? null,
                'district' => $row['district'] ?? null,
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
                'class_status' => $row['class_status'] ?? null,
                'establishment_date' => $row['establishment_date'] ?? null,
                'start_time' => $row['start_time'] ?? null,
                'end_time' => $row['end_time'] ?? null,
                'shift' => $row['shift'] ?? null,
                'is_cluster' => $row['is_cluster'] ?? false,
                'female_teachers' => $row['female_teachers'] ?? null,
                'male_teachers' => $row['male_teachers'] ?? null,
                'cbe_teachers' => $row['cbe_teachers'] ?? null,
                'is_closed' => $row['is_closed'] ?? false,
                'closure_date' => $row['closure_date'] ?? null,
                'closure_reason' => $row['closure_reason'] ?? null,
                'female_sms_members' => $row['female_sms_members'] ?? null,
                'male_sms_members' => $row['male_sms_members'] ?? null,
                'sms_members' => $row['sms_members'] ?? null,
                'has_hub_school' => $row['has_hub_school'] ?? false,
                'hub_school_name' => $row['hub_school_name'] ?? null,
                'hub_distance_km' => $row['hub_distance_km'] ?? null,
                'sip_completed' => $row['sip_completed'] ?? false,
                'remarks' => $row['remarks'] ?? null,
            ]);
        }
    }
}