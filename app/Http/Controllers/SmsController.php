<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;


class SmsController extends Controller
{
    public function sms()
    {
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '24d1d37813f5946b0162c4b28e89f7f226c3e21feeb1f6ef84827eef9c7ccabd'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);
        // Get one of the services
        $sms      = $AT->sms();
        // Use the service
        $result   = $sms->send([
            'to'      => '0731090832',
            'message' => 'Hello there!'
        ]);

        print_r($result);
    }
}
