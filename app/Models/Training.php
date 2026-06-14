<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $guarded = [];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function districts(){
        return $this->belongsToMany(District::class, 'training_districts');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function participants(){
        return $this->hasMany(TrainingParticipant::class);
    }

    public function trainingType(){
        return $this->belongsTo(TrainingType::class);
    }
}
