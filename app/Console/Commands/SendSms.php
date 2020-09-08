<?php

namespace App\Console\Commands;

use App\Services\SmsService;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Console\Command;
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
            return;
        };
        $mobile = $this->ask('number to: ');        
        $message = $this->ask('message: ');        
        $contactwithmessage=[
            'message'=>$message,
            'mobile'=>$mobile
        ];
        
        $report = SmsService::sendMessage([$contactwithmessage], $business);
        $this->info('Report from server sms: '.var_export($report,true));
        // Generate local notification
        Notifynder::category('sms.send')
            ->from('App\Console\Commands', 0)
            ->to('App\SmsService', 0)
            ->url('http://localhost')
            ->extra(compact('report'))
            ->send();
    }

}
