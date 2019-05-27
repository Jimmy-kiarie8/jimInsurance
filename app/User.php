<?php

namespace App;

use App\Notifications\verifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

// use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
	use Notifiable, SoftDeletes, HasRoles;

	public $with = ['roles'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'verifyToken', 'status', 'company',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	/**
	 * The roles that belong to the user.
	 */
	// public function roles() {
	// 	return $this->belongsToMany('App\Role');
	// }
	
	public function company() {
		return $this->belongsTo('App\Company');
	}

    public function verified()
    {
        return $this->verifyToken === null;
    }

    public function sendVerificationEmail()
    {
        $this->notify(new verifyEmail($this));
    }

	/**
	 * Get all user permissions.
	 *
	 * @return bool
	 */
	public function getAllPermissionsAttribute()
	{
		return $this->getAllPermissions();
	}
	public function getReferrals()
	{
		return ReferralProgram::all()->map(function ($program) {
			return ReferralLink::getReferral($this, $program);
		});
	}
}
