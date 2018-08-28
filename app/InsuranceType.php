<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceType extends Model
{
    public function policies()
    {
        return $this->belongsTo('App\Policy', 'InsType_id');
    }
}
