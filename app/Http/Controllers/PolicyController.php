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
        $policy->branch_id = Auth::user()->branch_id;
        $policy->file_no = 'file_'.$request->file_no;
        $policy->policy_no = 'policy_'.$request->policy_no;
        $policy->effective_date = $request->effective_date;
        $policy->exp_date = $request->exp_date;
        $policy->premium = $request->premium;
        $policy->commission = $request->commission;
        // $policy->client = $request->client;
        $policy->client_id = $request->client_id;
        $policy->InsType_id = $request->InsType_id;
        $policy->Insclass_id = $request->InsClass_id;
        $policy->policy_status_id = $request->policy_status_id;
        $policy->save();
        return $policy;
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
        $policy->branch_id = Auth::user()->branch_id;
        $policy->file_no = 'file_'.$request->form['file_no'];
        $policy->policy_no = 'policy_'.$request->form['policy_no'];
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
    public function destroy(Policy $policy)
    {
        //
    }

    public function getPolicy()
    {
        return Policy::all();
    }
}
