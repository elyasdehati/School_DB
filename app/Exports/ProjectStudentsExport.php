<?php

namespace App\Exports;

use App\Models\ProjectStudent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectStudentsExport implements FromCollection, WithHeadings
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

        return ProjectStudent::with(['province','district','class'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {
                return [
                    'student_id' => $item->student_id,
                    'class_id' => $item->class_id,
                    'province' => $item->province?->name,
                    'district' => $item->district?->name,
                    'village' => $item->village,
                    'asas_no' => $item->asas_no,
                    'enrollment_date' => $item->enrollment_date,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'father_name' => $item->father_name,
                    'tazkira_no' => $item->tazkira_no,
                    'year_of_birth' => $item->year_of_birth,
                    'age' => $item->age,
                    'gender' => $item->gender,
                    'native_language' => $item->native_language,
                    'residence_type' => $item->residence_type,
                    'is_disabled' => $item->is_disabled ? 'Yes' : 'No',
                    'disability_type' => $item->disability_type,
                    'guardian_phone' => $item->guardian_phone,
                    'guardian_relation' => $item->guardian_relation,
                    'status' => $item->status,
                    'remarks' => $item->remarks,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Student ID',
            'Class ID',
            'Province',
            'District',
            'Village',
            'ASAS No',
            'Enrollment Date',
            'First Name',
            'Last Name',
            'Father Name',
            'Tazkira No',
            'Year Birth',
            'Age',
            'Gender',
            'Native Language',
            'Residence Type',
            'Is Disabled',
            'Disability Type',
            'Guardian Phone',
            'Guardian Relation',
            'Status',
            'Remarks',
        ];
    }
}