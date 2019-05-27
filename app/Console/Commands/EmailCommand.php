<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reminder;

class EmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:testcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A Test Command';

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
        $reminder = new Reminder;
        $reminder->policy_id = 1;
        $reminder->client_id = 1;
        $reminder->save();
        dd($reminder);
    }
}
