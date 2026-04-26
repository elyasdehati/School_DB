<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShuraMember extends Model
{
    protected $guarded = [];

    public function shura(){
        return $this->belongsTo(ProjectShura::class, 'shura_id', 'sno');
    }
}
