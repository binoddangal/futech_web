<?php

namespace App\Mail\SiteSetting;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SMTPTestEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = getSetting();
        return $this->view('emails.site-setting.test-email')
            ->subject("Test email")
            ->from($setting->mail_from_address, $setting->mail_sender_name);
    }
}
