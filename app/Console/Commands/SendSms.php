<?php

namespace App\Console\Commands;

use App\Http\Controllers\SmsContrller;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Timegridio\Concierge\Models\Business;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message text';

    protected $process = [];
     
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
        //
        $id_business = $this->ask('id business: ');        
        $business = Business::find($id_business);
        if(!$business) {
            $this->info('Can\'t find business');
            return -1;
        };
        $mobile = $this->ask('number to: ');        
        $message = $this->ask('message: ');        
        $contactwithmessage=[
            'message'=>$message,
            'mobile'=>$mobile
        ];
        
        $report = SmsContrller::sendMessage([$contactwithmessage], $business);
        $this->info('Report from server sms: '.var_export($report,true));
    }

}
