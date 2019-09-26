<?php

namespace App\Http\Controllers;

use App\Imports\ContactImport;
use App\models\Group;
use App\Smscontact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function importContacts(Request $request)
    {
        // dd($request->all());
        $contacts = Excel::toArray(new ContactImport, request()->file('contacts'));
        $arr = $contacts[0];
        $user_id = Auth::id();
        foreach ($arr as $key => $contact) {
            $contact_d = new Smscontact();
            $contact_d->name =  $contact['name'];
            $contact_d->email = (array_key_exists('email', $contact)) ? $contact['email'] : null;
            $contact_d->phone = $contact['phone'];
            $contact_d->user_id = $user_id;
            $group_id = Group::select('id')->where('group_name', 'LIKE', "%{$contact['group']}%")->first();
            $contact_d->group_id = ($group_id) ? $group_id->id : null;
            $contact_d->save();
        }
        return redirect('/#/sms');
    }
}
