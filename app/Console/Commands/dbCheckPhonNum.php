<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbCheckPhonNum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:checkphone {business?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify phone numbers';

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
        $allRows = \Timegridio\Concierge\Models\Contact::query()
                ->get()
                ->all()
                ;
        foreach($allRows as $row){
            if(!empty($row->mobile)){
                echo $row->mobile;
                if(preg_match("#\+48#isU",$row->mobile)) break;
                //dd($row);
                echo "\r\n----\r\n";
            }
        }
        
    }
}
