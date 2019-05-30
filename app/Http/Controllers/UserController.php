<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Role_user;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SignupActivate;

class UserController extends Controller
{
	public function getUsers()
	{
		// return User::all();
		// return User::where('company_id', Auth::user()->company_id)->get();
		$users = User::orderBy('name')->get();
		// $users->transform(function ($user, $key) {
		//     $branch_name = Branch::find($user->company_id);
		//     $country_name = Country::find($user->country_id);
		//     $user->branch = $branch_name->branch_name;
		//     $user->country = $country_name->country_name;
		//     $user->status = 'active';
		//     return $user;
		// });
		// return $users;
		return response()->json($users);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// return $request->all();
		// var_dump($request->form); die;
		$user = new User;
        $password = $this->generateRandomString();
        $password_hash = Hash::make($password);
        $user->password = $password_hash;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->company_id = Auth::user()->company_id;
		$user->address = $request->address;
		$user->verifyToken = str_random(60);
		$user->save();
		$user->assignRole($request->role_id);
        $user->notify(new SignupActivate($user, $password));
		return $user;
	}

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, User $user)
	{
		// return $request->all();
		$user = User::find($request->id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->phone = $request->phone;
		$user->company_id = Auth::user()->company_id;
		$user->address = $request->address;

		$user->save();
		$user->assignRole($request->role_id);
		return $user;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(User $user)
	{
		User::find($user->id)->delete();
	}

	public function getLogedinUsers()
	{
		return Auth::user();
	}

	public function profile(Request $request, User $user, $id)
	{
		// return $request->all;
		$upload = User::find($request->id);
		if ($request->hasFile('image')) {
			$imagename = time() . $request->image->getClientOriginalName();
			$request->image->storeAs('public/profile', $imagename);
			// return response();
		}
		$image_name = '/storage/profile/' . $imagename;
		$upload->profile = $image_name;
		$upload->save();
	}

	public function getDrivers()
	{
		$users = User::all();
		$userArr = [];
		foreach ($users as $user) {
			// var_dump($user->roles); die;
			foreach ($user->roles as $role) {
				if ($role->name == 'Driver') {
					$userArr[] = $role->pivot->user_id;
				}
			}
		}
		$drivers = User::whereIn('id', $userArr)->get();
		return $drivers;
	}

	public function getCustomer()
	{
		$users = User::all();
		$userArr = [];
		foreach ($users as $user) {
			foreach ($user->roles as $role) {
				if ($role->name == 'Customer') {
					$userArr[] = $role->pivot->user_id;
				}
			}
		}
		$customers = User::whereIn('id', $userArr)->get();
		return json_decode(json_encode($customers));
	}

	public function getSorted(Request $request)
	{
		// return $request->all();
		$roles = User::all();
		$users_id = [];
		if ($request->abbr == 'all') {
			return $roles;
		} else {
			foreach ($roles as $role) {
				foreach ($role->roles as $user_role) {
					if ($user_role->pivot->role_id == $request->abbr) {
						$users_id[] = $user_role->pivot->user_id;
					}
				}
			}
		}
		return User::whereIn('id', $users_id)->get();
		// return $users_id;
		// return User::where()->get();
	}
	public function logoutOther()
	{
		return view('auth.Logout');
	}

	public function logOtherDevices(Request $request)
	{
		Auth::logoutOtherDevices($request->password);
		return redirect('/');
	}
}
