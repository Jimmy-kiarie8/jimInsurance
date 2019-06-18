<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AfricasTalking\SDK\AfricasTalking;

class Sms extends Model
{
    public function sms($phone, $policy)
    {
        // $username = 'willow'; // use 'sandbox' for development in the test environment
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '24d1d37813f5946b0162c4b28e89f7f226c3e21feeb1f6ef84827eef9c7ccabd'; // use your sandbox app API key for development in the test environment
        // $apiKey   = 'b0e5f4a4dcb976d75278dd607077f4697aaba64dd37741f2751fd23f40f33610'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'to'      => $phone,
            'message' => 'Dear '. $policy->name . ', your motor vehicle expires on ' . $policy->exp_date.' The premium is Kshs'.$policy->premium .' with a car value of'
            // 'message' => 'Hello',
        ]);
        print_r($result);
    }

    public function birthday($phone, $policy)
    {
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        // $username = 'willow'; // use 'sandbox' for development in the test environment
        $apiKey   = '24d1d37813f5946b0162c4b28e89f7f226c3e21feeb1f6ef84827eef9c7ccabd'; // use your sandbox app API key for development in the test environment
        // $apiKey   = 'b0e5f4a4dcb976d75278dd607077f4697aaba64dd37741f2751fd23f40f33610'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'to'      => $phone,
            'message' => "Dear ". $policy->name . ", here is to a happy birthday. We wish you many more. Enjoy your day",
            // 'message' => 'Hello',
        ]);
        print_r($result);
    }
}
