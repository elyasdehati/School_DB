<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainingExport implements FromCollection, WithHeadings
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

        return Training::with(['project','province','districts','status'])
            ->where('project_id', $this->project_id)
            ->get()
            ->map(function ($item) {

                return [
                    'project' => $item->project?->name,
                    'province' => $item->province?->name,
                    'districts' => $item->districts->pluck('name')->implode(', '),
                    'village' => $item->village,
                    'venue' => $item->training_venue,
                    'type' => $item->training_type,
                    'topic' => $item->training_topic,
                    'start_date' => $item->training_start_date,
                    'end_date' => $item->training_end_date,
                    'facilitator' => $item->facilitator_name,
                    'position' => $item->facilitator_position,
                    'male' => $item->male_participants,
                    'female' => $item->female_participants,
                    'gov' => $item->gov_participants,
                    'pre_test' => $item->avg_pre_test,
                    'post_test' => $item->avg_post_test,
                    'objective' => $item->objective,
                    'remarks' => $item->remarks,
                    'status' => $item->status?->name,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Project',
            'Province',
            'Districts',
            'Village',
            'Venue',
            'Type',
            'Topic',
            'Start Date',
            'End Date',
            'Facilitator',
            'Position',
            'Male',
            'Female',
            'Gov',
            'Pre Test',
            'Post Test',
            'Objective',
            'Remarks',
            'Status',
        ];
    }

    // ✅ ADDITION: helper for template detection
    public function isTemplate()
    {
        return !$this->withData;
    }
}