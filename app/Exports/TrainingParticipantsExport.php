<?php

namespace App\Exports;

use App\Models\TrainingParticipant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainingParticipantsExport implements FromCollection, WithHeadings
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

        return TrainingParticipant::with(['project', 'province', 'district'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {
                return [
                    'project' => $item->project?->name,
                    'training_type' => $item->training_type,
                    'province' => $item->province?->name,
                    'district' => $item->district?->name,
                    'village' => $item->village,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'father_name' => $item->father_name,
                    'trainee_type' => $item->trainee_type,
                    'gender' => $item->gender,
                    'age' => $item->age,
                    'is_disabled' => $item->is_disabled ? 'Yes' : 'No',
                    'disability_type' => $item->disability_type,
                    'phone' => $item->phone,
                    'pre_test' => $item->pre_test,
                    'post_test' => $item->post_test,
                    'remarks' => $item->remarks,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Project',
            'Training Type',
            'Province',
            'District',
            'Village',
            'First Name',
            'Last Name',
            'Father Name',
            'Trainee Type',
            'Gender',
            'Age',
            'Disabled',
            'Disability Type',
            'Phone',
            'Pre Test',
            'Post Test',
            'Remarks',
        ];
    }
}