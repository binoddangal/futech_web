<?php

namespace App\Jobs\User;

use App\Mail\User\ApprovedOrRejectedUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ApprovedOrRejectedUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $first_name;
    protected $email;
    protected $remarks;
    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($first_name, $email, $remarks, $status)
    {
        $this->first_name = $first_name;
        $this->email = $email;
        $this->status = $status;
        $this->remarks = $remarks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $emailTemplate = getEmailTemplate('user', $this->status ,null);
        $acceptedData = [
            "first_name" => !empty($this->first_name) ? $this->first_name : null,
            "remarks" => !empty($this->remarks) ? $this->remarks : null,
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
        Mail::to($this->email)->send(new ApprovedOrRejectedUserMail($content, $emailTemplate));
    }
}
