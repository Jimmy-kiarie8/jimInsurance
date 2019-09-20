<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AfricasTalking\SDK\AfricasTalking;

class Sms extends Model
{
    public function sms($phone, $policy)
    {
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '2fd972d459061d98697de4170eef1bb5137d8f7a6d1c7e3c6a2a924cecacf203'; // use your sandbox app API key for development in the test environment


        // $username = 'willow'; // use 'sandbox' for development in the test environment
        // $apiKey   = 'ef0c4a1d3d2b347d2c7d173fb61b3841735bf523e1bbeda938508d782cf20153'; // Live



        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'to'      => $phone,
            'message' => 'Dear '. $policy->name . ', your motor vehicle expires on ' . $policy->exp_date.' The premium is Kshs'.$policy->premium .' with a car value of'
            // 'message' => 'Hello',
        ]);
        // print_r($result);
        return;
    }

    public function birthday($phone, $policy)
    {
        // $username = 'willow'; // use 'sandbox' for development in the test environment
        // $apiKey   = 'ef0c4a1d3d2b347d2c7d173fb61b3841735bf523e1bbeda938508d782cf20153'; // Live
        
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '2fd972d459061d98697de4170eef1bb5137d8f7a6d1c7e3c6a2a924cecacf203'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service

        $result   = $sms->send([
            'to'      => $phone,
            'message' => "Dear ". $policy->name . ", here is to a happy birthday. We wish you many more. Enjoy your day",
            // 'message' => 'Hello',
        ]);
        // print_r($result);
        return;
    }
    public function message($data, $message)
    {
        // $username = 'willow'; // Live
        // $apiKey   = 'ef0c4a1d3d2b347d2c7d173fb61b3841735bf523e1bbeda938508d782cf20153'; // Live


        $apiKey   = '2fd972d459061d98697de4170eef1bb5137d8f7a6d1c7e3c6a2a924cecacf203'; // use your sandbox app API key for development in the test environment
        $username = 'sandbox'; // use 'sandbox' for development in the test environment

        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'enqueue' => true,
            // 'from'    => 'willow',
            'to'      => $data['phone'],
            'message' => "Dear " . $data['name'] . ' . ' . $message,
            // 'message' => "Dear " . $data['name'] . ' <br /> ' . $message,
            // 'message' => 'Hello',
        ]);
        return;
        // print_r($result);
    }
}


