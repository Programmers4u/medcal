<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup files and databases';

    protected $process = [];
     
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        checkDir(env('STORAGE_PATH','').'/backups');

        $this->process[0] = new Process(sprintf(
            'mysqldump -u%s -p%s -h%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            storage_path('backups/backup_'. time().'.sql')
        ));

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        foreach($this->process as $i=>$process){
            try {
                $process->mustRun();
                $this->info('The '.$i.' backup has been proceed successfully.');
            } catch (ProcessFailedException $exception) {
                $this->error('The '.$i.' backup process has been failed.');
            }
        }
    }
}
