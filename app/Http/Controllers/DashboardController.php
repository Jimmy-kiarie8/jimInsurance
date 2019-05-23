<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Policy;
use App\Certificate;
use App\Branch;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function user_count()
    {
        return User::count();
    }
    public function client_count()
    {
        return Client::count();
    }
    public function t_policy_count()
    {
        return Policy::where('created_at', Carbon::today())->count();
    }
    public function policies_count()
    {
        return Policy::count();
    }
    public function certificate_batch()
    {
        return Certificate::count();
    }
    public function t_certificate_batch()
    {
        return Certificate::where('created_at', Carbon::today())->count();
    }
    public function branches_count()
    {
        return Branch::where('created_at', Carbon::today())->count();
    }
}
