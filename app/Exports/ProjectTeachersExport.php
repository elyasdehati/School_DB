<?php

namespace App\Exports;

use App\Models\ProjectTeacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectTeachersExport implements FromCollection, WithHeadings
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

        return ProjectTeacher::with(['province','district','status'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {
                return [
                    'serial_number' => $item->serial_number,
                    'class_id' => $item->class?->class_id,

                    'province' => $item->province?->name,
                    'district' => $item->district?->name,

                    'village' => $item->village,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'father_name' => $item->father_name,

                    'starting_date' => $item->starting_date,

                    // boolean → Yes / No
                    'is_active' => $item->status?->name,

                    'tazkira_number' => $item->tazkira_number,
                    'year_of_birth' => $item->year_of_birth,
                    'age' => $item->age,
                    'gender' => $item->gender,
                    'teacher_type' => $item->teacher_type,
                    'qualification' => $item->qualification,
                    'phone' => $item->phone,

                    // boolean → Yes / No
                    'core_training' => $item->core_training ? 'Yes' : 'No',
                    'refresher_training' => $item->refresher_training ? 'Yes' : 'No',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'serial_number',
            'class_id',
            'province',
            'district',
            'village',
            'first_name',
            'last_name',
            'father_name',
            'starting_date',
            'is_active',
            'tazkira_number',
            'year_of_birth',
            'age',
            'gender',
            'teacher_type',
            'qualification',
            'phone',
            'core_training',
            'refresher_training',
        ];
    }
}