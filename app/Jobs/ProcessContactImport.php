<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Timegridio\Concierge\Models\Business;

class ProcessContactImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

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
        $contacts = explode("\n" , Storage::get($this->pathToContactFile));
        
        foreach($contacts as $index => $contact) {
            $register = [
                'uuid' => $contact[0],
                'firstname' => $contact[1],
                'lastname' => $contact[2],
                'nin' => $contact[3],
                'gender' => $contact[4],
                'birthdate' => Carbon::parse($contact[5]),
                'mobile' => $contact[6],
                'email' => $contact[7],
                // 'mobile_country' => $contact['mobile_country']
            ];
            
            $this->business->addressbook()->register($register);
        };
        
        Storage::disk('local')->delete($this->pathToContactFile);
    }
}
