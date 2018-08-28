<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceClass extends Model
{
    
    public function policies()
    {
        return $this->belongsTo('App\Policy', 'InsClass_id');
    }
}
