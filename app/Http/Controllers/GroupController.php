<?php

namespace App\Http\Controllers;

use App\models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->group_name = $request->group_name;
        $group->user_id = Auth::id();
        $group->description = $request->description;
        $group->save();
        return $group;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        $group->group_name = $request->group_name;
        $group->description = $request->description;
        $group->save();
        return $group;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::find($id)->delete();
    }
}
