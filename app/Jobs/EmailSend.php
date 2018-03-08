<?php

namespace App\Jobs;

use App\Mail\UserReport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Demouser;

class EmailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(Demouser $user)
    {
        $this->user= $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserReport $mail)
    {
       // \Log::info($mail);
        $email = new UserReport($this->user);
        Mail::to($this->user->email)->queue($email);
        \Log::info("mail==> successfully send");
        
    }
}
