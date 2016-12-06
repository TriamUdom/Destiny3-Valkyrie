<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ApplicantController as ApplicantController;

class NotifyUI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifyui';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send passed application to UI';

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
        $this->info('Start retrieving passed applicant(s)');

        $passed_id = ApplicantController::getPassedApplicantID();
        if(!is_array($passed_id)){
            $this->error($passed_id);
            return $passed_id;
        }

        $this->info('Passed applicant(s) retrieved');

        $bar = $this->output->createProgressBar(count($users));

        foreach($passed_id as $id){
            $returnHttpCode = ApplicantController::notifyUIOnsuccess($id);
            if($returnHttpCode != 200){
                $this->error($returnHttpCode.' returned for ID : '.$id);
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info('All data have been sent');
    }
}
