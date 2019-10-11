<?php

namespace App\Http\Controllers;

use App\Client;
use App\Smscontact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sms;
use App\Message;
use App\MessageSms;
use App\models\Group;

class SmscontactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Smscontact::paginate(500);
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
        request()->validate(
            [
                'group' => 'required',
                'name' => 'required',
                'phone' => 'required|regex:/(07)[0-9]{8}/'
            ],
            [
                'name.required' => 'You have to choose the file!',
                'phone.regex' => 'The phone format is invalid. Please use 07.. formart and enter 10 numbers'
            ]
        );
        $sms = new Smscontact();
        $sms->group_id = $request->group;
        $sms->name = $request->name;
        $sms->phone = $request->phone;
        $sms->user_id = Auth::id();
        $sms->save();
        return $sms;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Smscontact  $smscontact
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
     * @param  \App\Smscontact  $smscontact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sms = Smscontact::find($id);
        $sms->group_id = $request->group_id;
        $sms->name = $request->name;
        $sms->phone = $request->phone;
        $sms->save();
        return $sms;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Smscontact  $smscontact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Smscontact::find($id)->delete();
    }

    public function sendSms(Request $request)
    {
        // return $request->all();
        $group = Group::select('group_name')->find($request->group);
        if ($group->group_name == 'Clients') {
            $selected = Client::all();
        } else {
            $selected = Smscontact::where('group_id', $request->group)->get();
        }
        $message = new Message();
        $message->message = $request->message;
        $message->user_id = Auth::id();
        $message->save();
        $phone = [];
        $sms = new Sms();
        foreach ($selected as $key => $value) {
            $messageSms = new MessageSms();
            $messageSms->message_id = $message->id;
            $messageSms->smscontact_id = $value['id'];
            $messageSms->save();
            $sms->message($value, $request->message);
            $phone[] = $value['phone'];
        }
        return;
    }

    public function sms_contact($search)
    {
        return Smscontact::where('name', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->paginate(500);
    }
}
