<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;
use Auth;
use App\Company;
use App\Client;
use Carbon\Carbon;

class PolicyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $policy = new Policy;
        $policy->user_id = Auth::id();
        $policy->file_no = $request->file_no;
        $policy->policy_no = 'policy_' . $request->policy_no;
        $policy->effective_date = $request->effective_date;
        $policy->exp_date = $request->exp_date;
        $policy->premium = $request->premium;
        // $policy->coverage = $request->coverage;
        $policy->insured = $request->insured;
        // $policy->commission_rate = $request->commission_rate;
        $policy->company_id = $request->company;
        $policy->client_id = $request->client_id;
        // $policy->InsType_id = $request->InsType_id;
        $policy->Insclass_id = $request->InsClass_id;
        // $policy->policy_status_id = $request->policy_status_id;
        $policy->save();
        return $policy;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Policy::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $policy = Policy::find($id);
        $policy->file_no = $request->file_no;
        // $policy->policy_no = 'policy_' . $request->policy_no;
        $policy->effective_date = $request->effective_date;
        $policy->exp_date = $request->exp_date;
        $policy->premium = $request->premium;
        // $policy->commission = $request->commission;
        // $policy->client = $request->client;
        // $policy->client_id = $request->client_id;
        // $policy->InsType_id = $request->InsType;
        $policy->Insclass_id = $request->Insclass;
        // $policy->policy_status_id = $request->policy;
        $policy->save();
        return $policy;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Policy::find($id)->delete();
    }

    public function getPolicy()
    {
        $policies = Policy::paginate(500);
        $policies->transform(function ($policy) {
            $client = Client::find($policy->client_id);
            if ($client) {
                $policy->client_name = $client->name;
                $policy->client_phone = $client->phone;
            }
            $policy->expDate = date('d-M-Y', strtotime($policy->exp_date));
            $policy->effectiveDate = date('d-M-Y', strtotime($policy->effective_date));
            $company = Company::find($policy->company_id);
            if ($company) {
                $policy->company_name = $company->company_name;
            }
            // $policy->effective_date = Carbon::('DD-MM-YY', $policy->created_at);

            return $policy;
        });
        return $policies;
    }

    public function file_no()
    {
        $file =  Policy::select('file_no')->orderBy('id', 'desc')->first();
        if ($file) {
            $file_array = explode('_', $file->file_no);
            return $file_array[1] + 1;
        } else {
            return 1;
        }
    }

    public function policy_search($search)
    {
        return Policy::where('policy_no', 'LIKE', "%{$search}%")->paginate(500);
    }
}
