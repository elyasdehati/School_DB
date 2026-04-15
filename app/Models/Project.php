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

}
