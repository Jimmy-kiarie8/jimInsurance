<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Policy;
use App\Reminder;
use App\Client;

class ReportController extends Controller
{
    public function premium(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if ($request->client) {
            $policies = Policy::whereBetween('created_at', [$start_date, $end_date])->where('client', $request->client)->get();
        } else {
            $policies = Policy::whereBetween('created_at', [$start_date, $end_date])->get();
        }
        // return $policies;
        $policies->transform(function ($policy) {
            $client = Client::find($policy->client_id);
            // dd($policy->client_id);
            $policy->client_no = $client->client_no;
            $policy->client_name = $client->name;
            $policy->balance = $policy->premium - $policy->premium_paid;
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
            return Policy::whereBetween('created_at', [$start_date, $end_date])->where('client', $request->client)->get();
        } else {
            return Policy::whereBetween('created_at', [$start_date, $end_date])->get();
        }
    }
    public function reminder(Request $request)
    {
        // return $request->all();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $reminders = Reminder::whereBetween('created_at', [$start_date, $end_date])->get();
        foreach ($reminders as $reminder) {
            $policies = Policy::where('id', $reminder->policy_id)->get();
            $policies->transform(function ($fields) {
                $client = Client::find($fields->client_id);
                // dd($fields->client_id);
                $fields->client_no = $client->client_no;
                $fields->client_phone = $client->phone;
                $fields->client_name = $client->name;
                $fields->balance = $fields->premium - $fields->premium_paid;
                return $fields;
            });
        }
        return $policies;
    }
}
