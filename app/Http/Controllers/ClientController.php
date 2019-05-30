<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $clients->transform(function ($client) {
            $client->birth_day = date('d-M-Y', strtotime($client->birth_day));
            return $client;
        });
        return $clients;
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
        $client->client_no = $request->client_no;
        $client->pin_no = $request->pin_no;
        $client->company_id = Auth::user()->company_id;
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
    public function update(Request $request, $id)
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
    public function destroy($id)
    {
        Client::findOrFail($id)->delete();
    }

    public function getClients()
    {
        $clients = Client::all();
        $clients->transform(function ($client) {
            $client->birth_day = date('d-M-Y', strtotime($client->birth_day));
            return $client;
        });
        return $clients;
    }

    public function client_no()
    {
        $file =  Client::select('client_no')->orderBy('id', 'desc')->first();
        if ($file) {
            $file_array = explode('_', $file->client_no);
            return $file_array[1] + 1;
        } else {
            return 1;
        }
    }
}
