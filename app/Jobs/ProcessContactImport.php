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
use Timegridio\Concierge\Models\Contact;

class ProcessContactImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 120;
    public $tries = 1;
    public $maxExceptions = 1;
    
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
        if(!is_file($this->pathToContactFile)) return;

        $contacts = fopen($this->pathToContactFile,'r');
        while ( ($item = fgetcsv($contacts,0,';') ) !== FALSE ) {

            $name = explode(" ",$item[2]);
            $gnr = '';
            if(isset($name[1]))
                $gnr = substr($name[1],strlen($name[1])-1,1) !== 'a' ? 'M' : 'F';

            $gender = $item[4] ? $item[4] : '';
            $gender = $gender!=='' ? $gender : $gnr;
            
            $register = [
                'foregin_user_id' => $item[0],
                'firstname' => isset($name[1]) ? $name[1] : $item[1],
                'lastname' => isset($name[0]) ? $name[0] : $item[2],
                'nin' => $item[3],
                'gender' => $gender,
                'birthdate' => $item[5] ? Carbon::parse($item[5]) : Carbon::now(),
                'mobile' => preg_match('/\d[. *]+/',$item[6]) ? $item[6] : '',
                'email' => $item[7],
                'postal_address' => $item[8] . ', ' .$item[9],
                'mobile_country' => 'PL',
                // 'user_id' => ,
            ];
            if(!$this->duplicate($register))
                $this->business->addressbook()->register($register);
        };
        unlink($this->pathToContactFile);
    }

    private function duplicate($register) : bool {
        
        $model = $this->business->contacts()
            ->where('firstname',$register['firstname'])
            ->where('lastname',$register['lastname'])
            ->where('mobile',$register['mobile'])
            ->get()
            ->toArray()
            ;
        return count($model) > 0 ? true : false;
    }

    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
        unlink($this->pathToContactFile);
    }    
}
