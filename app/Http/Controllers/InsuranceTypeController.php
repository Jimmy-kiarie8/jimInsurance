<?php

namespace App\Http\Controllers;

use App\InsuranceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsuranceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InsuranceType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $type = new InsuranceType;
        $type->user_id =Auth::id();
        $type->code = $request->code;
        $type->description = $request->description;
        $type->save();
        return $type;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InsuranceType  $insuranceType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return InsuranceType::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InsuranceType  $insuranceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $type = InsuranceType::find($id);
        $type->code = $request->code;
        $type->description = $request->description;
        $type->save();
        return $type;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InsuranceType  $insuranceType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InsuranceType::find($id)->delete();
    }
}
