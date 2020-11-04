<?php

namespace App\Jobs;

use App\Models\Datasets;
use App\Models\MedicalHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class ProcessDatasetImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 120;
    public $tries = 1;
    public $maxExceptions = 1;
    
    // private $business;
    // private $pathToContactFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        // $this->business = $business;
        // $this->pathToContactFile = $pathToContactFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $model = MedicalHistory::query()->get()->toArray();
        if(Datasets::all()->count() >= count($model)) return;
        foreach($model as $m) {
            $check = Datasets::where(Datasets::DATE_OF_EXAMINATION, $m['created_at'])
                ->where(Datasets::UUID, $m['contact_id'])
                ->get()
                ->count()
                ;
            if( $check === 0 ) {
            $edm = json_decode($m['json_data']);
            $contact = Contact::find($m['contact_id']);
            $birthdate = $contact ? $contact->birthday : '';
            $sex = $contact? $contact->gender : '';
            Datasets::create([
                Datasets::DATE_OF_EXAMINATION  => Carbon::parse($m['created_at']),
                Datasets::BIRTHDAY => Carbon::parse($birthdate),
                Datasets::SEX => $sex === 'M' ? Datasets::SEX_MALE : Datasets::SEX_FEMALE,
                Datasets::DIAGNOSIS => $edm->diagnosis,
                Datasets::PROCEDURES => $edm->procedures,  
                Datasets::UUID => $contact->id,      
            ]);   
            }; 
        }

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