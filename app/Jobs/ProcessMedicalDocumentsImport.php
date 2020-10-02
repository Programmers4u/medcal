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

class ProcessMedicalDocumentsImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 120;
    public $tries = 1;
    public $maxExceptions = 1;
    
    private $business;
    private $pathToMedicalDocumentFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Business $business, $pathToMedicalDocumentFile)
    {
        //
        $this->business = $business;
        $this->pathToMedicalDocumentFile = $pathToMedicalDocumentFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!is_file($this->pathToMedicalDocumentFile)) return;

        $medicalDocuments = file($this->pathToMedicalDocumentFile);
        for($indx=0;$indx<count($medicalDocuments);$indx++) {
            if($indx>200) break;
            $item = explode(";",str_replace("\"","",$medicalDocuments[$indx]));

            $name = explode(" ",$item[2]);
            
            $gender = $item[4] ? $item[4] : '';
            $gnr = substr($name[1],strlen($name[1])-1,1) !== 'a' ? 'M' : 'F';
            $gender = $gender!=='' ? $gender : $gnr;
            
            $register = [
                'foregin_user_id' => $item[0],
                'firstname' => $name[1],
                'lastname' => $name[0],
                'nin' => $item[3],
                'gender' => $gender,
                'birthdate' => $item[5] ? Carbon::parse($item[5]) : Carbon::now(),
                'mobile' => preg_match('/\d[. *]+/',$item[6]) ? $item[6] : '',
                'email' => $item[7],
                'postal_address' => $item[8] . ', ' .$item[9],
                'mobile_country' => 'PL',
            ];
            // try {
                // if(!$this->duplicate($register))
                // $this->business->addressbook()->register($register);
            // } catch(Exception $e) {
                // echo $e->getMessage();
            // };
        };
        // unlink($this->pathToMedicalDocumentFile);
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

    }    
}
