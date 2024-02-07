<?php

namespace App\Jobs\User\Auth;

use App\Mail\User\Auth\SendUserVerificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserVerificationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $userVerification;
    protected $verificationUrl;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$userVerification,$verificationUrl)
    {
        $this->user = $user;
        $this->userVerification = $userVerification;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {setSMTP();
        Mail::to($this->user->email)->send(new SendUserVerificationMail($this->user,$this->userVerification,$this->verificationUrl));
    }
}
