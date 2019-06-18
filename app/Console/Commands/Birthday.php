<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Client;
use App\Sms;

class Birthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:Birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Birthday wish sms';

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
        $birth_day = $today->format('d M');
        // dd($birth_day);
        $clients = Client::all();
            $clients->transform(function ($client) {
            $d_time = new Carbon($client->birth_day);
            // dd($d_time->format('d M'));
            $client->birth_day = $d_time->format('d M');
            return $client;
        });
        // dd($clients);
        foreach ($clients as $client) {
            if ($birth_day == $client->birth_day) {
                $sms = new Sms;
                $sms->birthday($client->phone, $client);
            }
            // $reminder = new Reminder;
            // $reminder->client_id = $policy->client_id;
            // $reminder->policy_id = $policy->id;
            // $reminder->save();
        }
    }
}
