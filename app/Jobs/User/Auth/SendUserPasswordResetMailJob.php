<?php

namespace App\Jobs\User\Auth;

use App\Mail\User\Auth\SendUserPasswordResetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserPasswordResetMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $passwordReset;
    protected $link;
    public function __construct($passwordReset,$link)
    {
        $this->passwordReset = $passwordReset;
        $this->link =$link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        setSMTP();
        Mail::to($this->passwordReset->email)->send(new SendUserPasswordResetMail($this->passwordReset,$this->link));
    }
}
