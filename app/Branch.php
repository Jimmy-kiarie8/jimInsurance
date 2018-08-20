<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function user()
    {
        return hasMany('App\User', 'branch_id');
    }
}
