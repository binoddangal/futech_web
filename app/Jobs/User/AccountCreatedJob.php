<?php

namespace App\Jobs\User;

use App\Mail\User\AccountCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AccountCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $password;
    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->email = $user->email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTemplate = getEmailTemplate('user','account_created',null);
        $acceptedData = [
            "email" => !empty($this->email) ? $this->email : null,
            "first_name" => !empty($this->user) ? $this->user->first_name : null,
            "password" => !empty($this->password) ? $this->password : null,
        ];

        /*Tags that needs to be rendered*/
        $acceptedTag = [];
        /*Tags that needs to be rendered*/

        /*Append Tag Data to HTML*/
        $acceptedInputs = explode(',', $emailTemplate->accepted_inputs);
        /*array_push($acceptedInputs,'href');*/
        /*array_push($acceptedInputs,'link_text');*/
        /*Append Tag Data to HTML*/

        $content = renderEmailHTML($emailTemplate->description, $acceptedTag);
        $content = renderEmailData($content,$acceptedInputs, $acceptedData);

        setSMTP();
        Mail::to($this->email)->send(new AccountCreatedMail($content, $emailTemplate));
    }
}
