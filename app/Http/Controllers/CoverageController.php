<?php

namespace App\Http\Controllers;

use App\Coverage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoverageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Coverage::all();
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
        $coverage = new Coverage;
        $coverage->user_id =Auth::id();
        $coverage->code = $request->code;
        $coverage->description = $request->description;
        $coverage->save();
        return $coverage;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coverage  $coverage
     * @return \Illuminate\Http\Response
     */
    public function show(Coverage $coverage)
    {
        return Coverage::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coverage  $coverage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coverage $coverage)
    {
        $coverage = Coverage::find($id);
        $coverage->code = $request->code;
        $coverage->description = $request->description;
        $coverage->save();
        return $coverage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coverage  $coverage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coverage $coverage)
    {
        Coverage::find($id)->delete();
    }
}
