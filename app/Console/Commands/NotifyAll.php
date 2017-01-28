<?php

namespace App\Console\Commands;

use Mail;
use App\PassedApplicant;
use Illuminate\Console\Command;

class NotifyAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifyall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all user about seating number';

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

        $all = PassedApplicant::get();

        $this->info('Passed applicant(s) retrieved');

        $bar = $this->output->createProgressBar(count($all));

        foreach($all as $individual){
            $applicantMail = $individual['email'];

            Mail::send('emails.seating', [], function($message) use ($applicantMail){
                $message->from('no-reply@apply.triamudom.ac.th', 'ระบบรับสมัครนักเรียนโควตาจังหวัด โรงเรียนเตรียมอุดมศึกษา');
                $message->to($applicantMail)->subject("ประกาศเลขที่นั่งสอบ สำหรับการสอบโควตาจังหวัด ปีการศึกษา 2560");
            });

            PassedApplicant::where('_id', $individual['_id'])->update(['seating_notified' => 1]);

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n");
        $this->info('All emails have been sent');
    }
}
