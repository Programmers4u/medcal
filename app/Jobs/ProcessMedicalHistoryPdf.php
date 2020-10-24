<?php

namespace App\Jobs;

use App\Events\GenerateMedicalHistoryPdf;
use App\Models\MedicalFile;
use App\Models\MedicalHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class ProcessMedicalHistoryPdf implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 120;
    public $tries = 1;
    public $maxExceptions = 1;
    
    private $business;
    private $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Business $business, Contact $contact)
    {
        //
        $this->business = $business;
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $historyData = MedicalHistory::query()
            ->select('medical_history.updated_at','medical_history.created_at','json_data','contacts.nin','contacts.gender','contacts.firstname','contacts.lastname','contacts.birthdate','humanresources.name')
            ->leftJoin('contacts','contacts.id','=','medical_history.contact_id')
            ->leftJoin('humanresources','humanresources.id','=','humanresources_id')
            ->where('medical_history.contact_id','=',$this->contact->id)
            ->get()
            ->toArray()
            ;

        $_files = MedicalFile::getFile($this->contact);
        $files = [];
        foreach($_files as $file) {
            array_push ($files, [
                'id'=>$file['id'],
                'url'=>Storage::url($file['file']),
                'description'=>$file['description'],
                'type'=>$file['type'],
                'medical_history_id'=>$file['medical_history_id'],
                'original_name' =>$file['$original_name'],
            ]);
        }
        $photos = $_files->items();
        $business = $this->business->get()->toArray();

        $pdf = Pdf::loadView('medical.pdf.export', compact('historyData','business','photos'));
        $fileName = (is_array($historyData)) ? $historyData[0]['lastname'].'_'.$historyData[0]['firstname'].'_history_document.pdf' : 'history_document.pdf';
        $path = storage_path();
        $pathFile = $path . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . $fileName;
        $pdf->save($pathFile);
        event(new GenerateMedicalHistoryPdf($this->contact, $this->business, $pathFile));
    }

    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...

    }    
}
