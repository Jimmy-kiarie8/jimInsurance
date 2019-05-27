<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Companyprofile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function insurance()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        $user = Auth::user();
        $auth_user = array_prepend($user->toArray(), $permissions, 'can');
        $companies = Companyprofile::where('id', Auth::user()->company_id)->get();
        foreach ($companies as $company) {
            $company_logo = $company->logo;
        }
        $newrole = Auth::user()->roles;
        return view('welcome', compact('auth_user', 'company_logo'));
    }
}
