<?php

namespace App\Exports;

use App\Models\ProjectShura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectShurasExport implements FromCollection, WithHeadings
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

        return ProjectShura::with(['province','district','classes','project'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {
                return [
                    'sno' => $item->sno,
                    'project' => $item->project?->name,
                    'province' => $item->province?->name,
                    'district' => $item->district?->name,
                    'village' => $item->village,
                    'shura_name' => $item->shura_name,
                    'establishment_date' => $item->shura_establishment_date,
                    'classes' => implode(', ', $item->classes->pluck('class_name')->toArray()),
                    'status' => $item->status,
                    'status_change_date' => $item->status_change_date,
                    'status_change_reason' => $item->status_change_reason,
                    'remarks' => $item->remarks,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'sno',
            'project',
            'province',
            'district',
            'village',
            'shura_name',
            'establishment_date',
            'classes',
            'status',
            'status_change_date',
            'status_change_reason',
            'remarks',
        ];
    }
}