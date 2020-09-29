<?php

namespace App\Jobs;

use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Business;

class ProcessContactImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 0;
    
    private $business;
    private $pathToContactFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Business $business, $pathToContactFile)
    {
        //
        $this->business = $business;
        $this->pathToContactFile = $pathToContactFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contacts = file($this->pathToContactFile);
        for($indx=0;$indx<count($contacts);$indx++) {
            $item = explode(";",str_replace("\"","",$contacts[$indx]));
            $name = explode(" ",$item[2]);
            $register = [
                'foregin_user_id' => $item[0],
                'firstname' => $name[1],//$item[1],
                'lastname' => $name[0],//$item[2],
                'nin' => $item[3],
                'gender' => $item[4] 
                    ? $item[4] 
                    : rand(0,1) 
                        ? 'F' 
                        : 'M',
                'birthdate' => $item[5] ? Carbon::parse($item[5]) : Carbon::now(),
                'mobile' => $item[6],
                'email' => $item[7],
                'postal_address' => $item[8] . ', ' .$item[9],
                'mobile_country' => 'PL',
            ];
            try {
                $this->business->addressbook()->register($register);
            } catch(Exception $e){
                
            }
        };
        // unlink($this->pathToContactFile);
        // return true;
    }
}
