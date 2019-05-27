<?php

namespace App\Http\Controllers;

use App\PolicyStatus;
use Illuminate\Http\Request;
use Auth;

class PolicyStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PolicyStatus::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $policy = new PolicyStatus;
        $policy->user_id = Auth::id();
        $policy->code = $request->code;
        $policy->description = $request->description;
        $policy->save();
        return $policy;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PolicyStatus  $policyStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PolicyStatus::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PolicyStatus  $policyStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $policy = PolicyStatus::find($id);
        $policy->code = $request->code;
        $policy->description = $request->description;
        $policy->save();
        return $policy;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PolicyStatus  $policyStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PolicyStatus::find($id)->delete();
    }
}
