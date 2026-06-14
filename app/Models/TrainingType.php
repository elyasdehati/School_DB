<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    protected $guarded = [];

    public function trainings(){
        return $this->hasMany(Training::class);
    }
}
