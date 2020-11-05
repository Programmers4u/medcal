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

        $datasets = file($this->pathToDatasetsFile);
        for($indx=0;$indx<count($datasets);$indx++) {
            
            if($indx>20000) break;

            Datasets::create([
                Datasets::DATE_OF_EXAMINATION  => Carbon::parse($datasets[$indx][0]),
                Datasets::BIRTHDAY => Carbon::parse($datasets[$indx][1]),
                Datasets::SEX => $datasets[$indx][2],
                Datasets::DIAGNOSIS => $datasets[$indx][3],
                Datasets::PROCEDURES => $datasets[$indx][4],  
                Datasets::UUID => $datasets[$indx][5],      
            ]);   
        };
        unlink($this->pathToDatasetsFile);
    }

    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...

    }    
}
