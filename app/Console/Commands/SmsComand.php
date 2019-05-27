<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Policy;
use Carbon\Carbon;
use App\Sms;
use App\Client;
use App\Reminder;

class SmsComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:Sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = Carbon::today();
        $sms_date = $today->addDays(7)->toDateString();
        $policies = Policy::all();
        $policies->transform(function ($policy) {
            $policy->exp_date = $policy->exp_date;
            $client = Client::find($policy->client_id);
            $policy->name = $client->name;
            $policy->phone = $client->phone;
            return $policy;
        });
        foreach ($policies as $policy) {
            if ($sms_date  == $policy->exp_date) {
                $sms = new Sms;
                $sms->sms($policy->phone, $policy);
            }
            $reminder = new Reminder;
            $reminder->client_id = $policy->client_id;
            $reminder->policy_id = $policy->id;
            $reminder->save();
        }
    }
}
