<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectShura extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    
    public function classes(){
        return $this->belongsToMany(ProjectClass::class, 'project_shura_class');
    }

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }
}
