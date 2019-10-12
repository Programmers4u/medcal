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
        $this->process[0] = new Process(sprintf(
            'mysqldump -u%s -p%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            storage_path('backups/backup_'. time().'.sql')
        ));
        $this->process[1] = new Process('echo "OK" ');
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
