<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectClass extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function students(){
        return $this->hasMany(ProjectClass::class, 'class_id');
    }

    public function shuras(){
        return $this->belongsToMany(ProjectShura::class, 'project_shura_class');
    }

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }
}
