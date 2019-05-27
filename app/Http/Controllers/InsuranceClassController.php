<?php

namespace App\Http\Controllers;

use App\InsuranceClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsuranceClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InsuranceClass::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insurance = new InsuranceClass;
        $insurance->user_id = Auth::id();
        $insurance->code = $request->code;
        $insurance->commission_rate = $request->commission_rate;
        $insurance->coverage = $request->coverage;
        $insurance->description = $request->description;
        $insurance->save();
        return $insurance;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InsuranceClass  $insuranceClass
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InsuranceClass::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsuranceClass  $insuranceClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $insurance = InsuranceClass::find($id);
        // $insurance->title = $request->title;
        $insurance->description = $request->description;
        $insurance->code = $request->code;
        $insurance->commission_rate = $request->commission_rate;
        $insurance->coverage = $request->coverage;
        $insurance->save();
        return $insurance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsuranceClass  $insuranceClass
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InsuranceClass::find($id)->delete();
    }
}
