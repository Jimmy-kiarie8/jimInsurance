<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policy;
use App\Reminder;
use App\Client;
use App\InsuranceClass;

class ReportController extends Controller
{
    public function premium(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($request->client) {
            $policies = Policy::whereBetween('created_at', [$start_date, $end_date])->where('client_id', $request->client)->get();
        } else {
            $policies = Policy::whereBetween('created_at', [$start_date, $end_date])->get();
        }
        // return $policies;
        $policies->transform(function ($policy) {
            $ins_class = InsuranceClass::find($policy->InsClass_id);
            // dd($policy->InsClass_id);
            $policy->insurance_class = ($ins_class) ? $ins_class->code : '' ;
            $client = Client::find($policy->client_id);
            // dd($policy->client_id);
            if ($client) {
                $policy->client_no = $client->client_no;
                $policy->client_name = $client->name;
                $policy->balance = $policy->premium - $policy->premium_paid;
            }
            return $policy;
        });
        return $policies;
    }

    public function products(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report = $request->Rtype;
        if ($request->client) {
            return Policy::whereBetween('created_at', [$start_date, $end_date])->get();
        } else {
            return Policy::whereBetween('created_at', [$start_date, $end_date])->get();
        }
    }
    public function reminder(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        // dd([$start_date, $end_date]);
        $policies = Policy::whereBetween('exp_date', [$start_date, $end_date])->get();
        $policies->transform(function ($policy) {
            $ins_class = InsuranceClass::find($policy->InsClass_id);
            // dd($policy->InsClass_id);
            $policy->insurance_class = ($ins_class) ? $ins_class->code : '' ;
            $clients = Client::find($policy->client_id);
            if ($clients) {
                $policy->client_no = $clients->client_no;
                $policy->client_name = $clients->name;
                $policy->client_phone = $clients->phone;
            }
            return $policy;
        });
        return $policies;
    }
}
