<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStudent extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function class(){
        return $this->belongsTo(ProjectClass::class, 'class_id', 'class_id');
    }
}
