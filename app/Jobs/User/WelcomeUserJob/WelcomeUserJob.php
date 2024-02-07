<?php

namespace App\Jobs\User\WelcomeUserJob;

use App\Mail\User\WelcomeUserMail\WelcomeUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class WelcomeUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;
    protected $first_name;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $first_name, $email)
    {
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $emailTemplate = getEmailTemplate('user','welcome_email',null);
        $acceptedData = [
            "first_name" => !empty($this->first_name) ? $this->first_name : null,
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

        // User notifications store
        // $user_notification['title'] = $emailTemplate->title;
        // $user_notification['content'] = $content;
        // $user_notification['date_sent'] = \Carbon\Carbon::now()->toDateTimeString();
        // $user_notification['user_id'] = $this->user_id;
        // storeUserNotification($user_notification);

        setSMTP();
        Mail::to($this->email)->send(new WelcomeUserMail($content, $emailTemplate));
    }
}
