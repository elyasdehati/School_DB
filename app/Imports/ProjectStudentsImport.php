<?php

namespace App\Imports;

use App\Models\ProjectStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectStudentsImport implements ToModel, WithHeadingRow
{
    private $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProjectStudent([
            'project_id' => $this->project_id,
            'student_id' => $row['student_id'],
            'class_id' => $row['class_id'],
            // 'class_name' => $row['class_name'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'province' => $row['province'],
            'district' => $row['district'],
            'village' => $row['village'],
        ]);
    }
}