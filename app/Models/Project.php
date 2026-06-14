<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function teachers(){
        return $this->hasMany(ProjectTeacher::class);
    }

    public function class(){
        return $this->hasMany(ProjectClass::class);
    }

    public function students(){
        return $this->hasMany(ProjectStudent::class);
    }

    public function status(){
        return $this->belongsTo(ProjectStatus::class);
    }

    public function shuraMembers(){
        return $this->hasMany(ShuraMember::class);
    }

    public function shuras(){
        return $this->hasMany(ProjectShura::class);
    }

    public function trainings(){
        return $this->hasMany(Training::class);
    }

    public function trainingParticipants(){
        return $this->hasMany(TrainingParticipant::class);
    }
}