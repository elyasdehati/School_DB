<?php

namespace App\Exports;

use App\Models\ShuraMember;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShuraMembersExport implements FromCollection, WithHeadings
{
    protected $project_id;
    protected $withData;

    public function __construct($project_id, $withData = true)
    {
        $this->project_id = $project_id;
        $this->withData = $withData;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if (!$this->withData) {
            return collect([]);
        }

        return ShuraMember::with(['shura.project'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {
                return [
                    'shura_sno' => $item->shura->sno ?? '',
                    'project' => $item->shura->project?->name ?? '',
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'father_name' => $item->father_name,
                    'tazkira_no' => $item->tazkira_no,
                    'year_of_birth' => $item->year_of_birth,
                    'age' => $item->age,
                    'gender' => $item->gender,
                    'education_level' => $item->education_level,
                    'language' => $item->language,
                    'residence_type' => $item->residence_type,
                    'is_disabled' => $item->is_disabled ? 'Yes' : 'No',
                    'disability_type' => $item->disability_type,
                    'role' => $item->role,
                    'phone' => $item->phone,
                    'status' => $item->status ? 'Active' : 'Inactive',
                    'remarks' => $item->remarks,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'shura_sno',
            'project',
            'first_name',
            'last_name',
            'father_name',
            'tazkira_no',
            'year_of_birth',
            'age',
            'gender',
            'education_level',
            'language',
            'residence_type',
            'disabled',
            'disability_type',
            'role',
            'phone',
            'status',
            'remarks',
        ];
    }
}