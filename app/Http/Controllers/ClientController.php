<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Auth;

class ClientController extends Controller
{
    public function index()
    {
        return Client::all();
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
        $client = new Client;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->birth_day = $request->birth_day;
        $client->client_no = 'client_'.$request->client_no;
        $client->pin_no = $request->pin_no;
        $client->branch_id = Auth::user()->branch_id;
        $client->user_id = Auth::id();
        $client->save();
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // return $request->all();
        $client = Client::find($request->id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->birth_day = $request->birth_day;
        $client->client_no = $request->client_no;
        $client->pin_no = $request->pin_no;
        $client->save();
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    public function getClients()
    {
        return Client::all();
    }
}
