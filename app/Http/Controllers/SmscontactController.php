<?php

namespace App\Http\Controllers;

use App\Smscontact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sms;
use App\Message;
use App\MessageSms;

class SmscontactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Smscontact::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(
            [
                'name' => 'required',
                'phone' => 'required|regex:/(07)[0-9]{8}/'
            ],
            [
                'name.required' => 'You have to choose the file!',
                'phone.regex' => 'The phone format is invalid. Please use 07.. formart and enter 10 numbers'
            ]
        );
        // return $request->all();
        $sms = new Smscontact();
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
        //
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
        $message = new Message();
        $message->message = $request->message;
        $message->user_id = Auth::id();
        $message->save();
        $phone = [];
        $sms = new Sms();
        foreach ($request->selected as $key => $value) {
            $messageSms = new MessageSms();
            $messageSms->message_id = $message->id;
            $messageSms->smscontact_id = $value['id'];
            // dd($value);
            $messageSms->save();
            $sms->message($value, $request->message);
            $phone[] = $value['phone'];
        }
        // dd($phone);
    }
}

// Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veniam saepe dolore porro deserunt est blanditiis laboriosam, omnis placeat, minima laudantium veritatis deleniti eum quam error quo! Voluptatibus blanditiis illum nisi.
