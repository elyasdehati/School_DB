<?php

namespace App\Exports;

use App\Models\ProjectClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectClassesExport implements FromCollection, WithHeadings
{
    protected $project_id;
    protected $withData;

    public function __construct($project_id, $withData = true)
    {
        $this->project_id = $project_id;
        $this->withData = $withData;
    }

    public function collection()
    {
        if (!$this->withData) {
            return collect([]);
        }

        return ProjectClass::with(['province','district'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {
                return [
                    'registration_date' => $item->registration_date,
                    'class_id' => $item->class_id,
                    'class_name' => $item->class_name,
                    'grades' => $item->grades ?: '',
                    'class_type' => $item->class_type,
                    'province' => $item->province?->name,
                    'district' => $item->district?->name,
                    'village' => $item->village,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'climate' => $item->climate,
                    'infrastructure' => $item->infrastructure,
                    'boys_enrolled' => $item->boys_enrolled,
                    'girls_enrolled' => $item->girls_enrolled,
                    'total_enrolled' => $item->total_enrolled,
                    'demographic' => $item->demographic,
                    'language' => $item->language,
                    'class_status' => $item->class_status ? 'Active' : 'Inactive',
                    'establishment_date' => $item->establishment_date,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'shift' => $item->shift,
                    'is_cluster' => $item->is_cluster ? 'Yes' : 'No',
                    'female_teachers' => $item->female_teachers,
                    'male_teachers' => $item->male_teachers,
                    'cbe_teachers' => $item->cbe_teachers,
                    'is_closed' => $item->is_closed ? 'Yes' : 'No',
                    'closure_date' => $item->closure_date,
                    'closure_reason' => $item->closure_reason,
                    'female_sms_members' => $item->female_sms_members,
                    'male_sms_members' => $item->male_sms_members,
                    'sms_members' => $item->sms_members,
                    'has_hub_school' => $item->has_hub_school ? 'Yes' : 'No',
                    'hub_school_name' => $item->hub_school_name,
                    'hub_distance_km' => $item->hub_distance_km,
                    'sip_completed' => $item->sip_completed ? 'Yes' : 'No',
                    'remarks' => $item->remarks,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'registration_date',
            'class_id',
            'class_name',
            'grades',
            'class_type',
            'province',
            'district',
            'village',
            'latitude',
            'longitude',
            'climate',
            'infrastructure',
            'boys_enrolled',
            'girls_enrolled',
            'total_enrolled',
            'demographic',
            'language',
            'class_status',
            'establishment_date',
            'start_time',
            'end_time',
            'shift',
            'is_cluster',
            'female_teachers',
            'male_teachers',
            'cbe_teachers',
            'is_closed',
            'closure_date',
            'closure_reason',
            'female_sms_members',
            'male_sms_members',
            'sms_members',
            'has_hub_school',
            'hub_school_name',
            'hub_distance_km',
            'sip_completed',
            'remarks',
        ];
    }
}