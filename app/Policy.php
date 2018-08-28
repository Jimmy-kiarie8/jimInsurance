<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    // public $with = ['InsClass', 'InsType', 'policyStatus'];
    public function InsClass()
    {
        return $this->belongsTo('App\InsuranceClass');
    }
    
    public function InsType()
    {
        return $this->belongsTo('App\InsuranceType');
    }
    
    public function policyStatus()
    {
        return $this->belongsTo('App\PolicyStatus');
    }
}
