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
    public function update(Request $request, Policy $policy)
    {
        
        // return $request->all();
        $policy = Policy::find($request->id);
        $policy->user_id = Auth::id();
        $policy->branch_id = Auth::user()->branch_id;
        $policy->file_no = $request->file_no;
        $policy->policy_no = $request->policy_no;
        $policy->effective_date = $request->effective_date;
        $policy->exp_date = $request->exp_date;
        $policy->premium = $request->premium;
        $policy->commission = $request->commission;
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
