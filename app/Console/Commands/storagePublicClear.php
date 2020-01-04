<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class storagePublicClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:public_clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all files from public/storage';

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
        $path = base_path().'/public/storage';
        $this->info('Clear: '.$path);
        $command = 'rm -r '.$path;
        system($command);
        $this->info('The clear has been proceed successfully.');
    }
}
