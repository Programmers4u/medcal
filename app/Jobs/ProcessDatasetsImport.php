<?php

namespace App\Jobs;

use App\Models\Datasets;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Timegridio\Concierge\Models\Business;

class ProcessDatasetsImport implements ShouldQueue
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

        $datasets = fopen($this->pathToDatasetsFile, 'r');
        while ( ($item = fgetcsv($datasets,0,';') ) !== FALSE ) {

            if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $item[0])) 
                $item[0] = Carbon::now()->format('Y-m-d H:i:s');
            if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $item[1])) 
                $item[1] = Carbon::now()->format('Y-m-d H:i:s');

            Datasets::create([
                Datasets::DATE_OF_EXAMINATION  => $item[0],
                Datasets::BIRTHDAY => $item[1],
                Datasets::SEX => $item[2],
                Datasets::DIAGNOSIS => $item[3],
                Datasets::PROCEDURES => $item[4],  
                Datasets::UUID => $item[5],      
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
