<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Applicant;

class FormatData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formatdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->info('Start retrieving applicant(s)');
        $all = Applicant::get();
        $this->info('Finished retrieving applicant(s)');

        $bar = $this->output->createProgressBar(count($all));

        foreach($all as $indi){
            Applicant::where('_id', $indi['_id'])->update([
                'documents' => [
                    'timestamp' => $indi['documents']['timestamp'],
                    'access_token' => $indi['documents']['access_token'],
                ],
                'ui_notified' => 0,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n");
        $this->info('All data have been modified');
    }
}
