<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeacher extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }
}
