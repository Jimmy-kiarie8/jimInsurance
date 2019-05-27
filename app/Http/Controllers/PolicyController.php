<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;
use Auth;

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
        $policy->coverage = $request->coverage;
        $policy->insured = $request->insured;
        $policy->commission_rate = $request->commission_rate;
        $policy->company_id = $request->company;
        $policy->client_id = $request->client_id;
        $policy->InsType_id = $request->InsType_id;
        $policy->Insclass_id = $request->InsClass_id;
        $policy->policy_status_id = $request->policy_status_id;
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
        return $request->all();
        $policy = Policy::find($id);
        $policy->file_no = $request->form['file_no'];
        $policy->policy_no = 'policy_' . $request->form['policy_no'];
        $policy->effective_date = $request->form['effective_date'];
        $policy->exp_date = $request->form['exp_date'];
        $policy->premium = $request->form['premium'];
        $policy->commission = $request->form['commission'];
        // $policy->client = $request->form['client'];
        $policy->client_id = $request->form['client_id'];
        $policy->InsType_id = $request->InsType;
        $policy->Insclass_id = $request->Insclass;
        $policy->policy_status_id = $request->policy;
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
        //
    }

    public function getPolicy()
    {
        return Policy::all();
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
}
