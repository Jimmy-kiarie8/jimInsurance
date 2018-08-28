<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolicyStatus extends Model
{
    public function policies()
    {
        return $this->belongsTo('App\Policy', 'policy_status_id');
    }
}
