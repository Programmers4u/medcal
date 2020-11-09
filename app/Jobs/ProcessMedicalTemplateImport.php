<?php

namespace App\Jobs;

use App\Models\Datasets;
use App\Models\MedicalTemplates;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Timegridio\Concierge\Models\Business;

class ProcessMedicalTemplateImport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 120;
    public $tries = 1;
    public $maxExceptions = 1;
    
    private $business;
    private $pathToDatasetsFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Business $business, $pathToDatasetsFile)
    {
        //
        $this->business = $business;
        $this->pathToDatasetsFile = $pathToDatasetsFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(!is_file($this->pathToDatasetsFile)) return;

        $validateImportColumns = [
            0 => '/\w+/isU',
            1 => '/A|Q/isU',
            2 => '/\w+/isU',
        ];

        $datasets = fopen($this->pathToDatasetsFile, 'r');
        while ( ($item = fgetcsv($datasets,0,';') ) !== FALSE ) {
            $valid = TRUE;
            foreach($validateImportColumns as $key=>$value) {
                if(!preg_match($value,$item[$key])) {
                    $valid = FALSE;
                    break;
                }
            };
            if(!$valid) continue;
            MedicalTemplates::updateOrCreate([
                MedicalTemplates::NAME => $item[0],
                MedicalTemplates::TYPE => $item[1],
                MedicalTemplates::DESCRIPTION => $item[2],
                MedicalTemplates::BUSINESS_ID => $this->business->id,
            ]);
        };
        unlink($this->pathToDatasetsFile);
    }

    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
        unlink($this->pathToDatasetsFile);
    }    
}
