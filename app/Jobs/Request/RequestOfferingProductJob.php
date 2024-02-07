<?php

namespace App\Jobs\Request;

use App\Mail\User\Request\RequestOfferingProductMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RequestOfferingProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $userEmails;
    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $userEmails, $email)
    {
        $this->request = $request;
        $this->userEmails = $userEmails;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTemplate = getEmailTemplate('user', 'request_offer_product');
        $acceptedData = [
            "first_name" => !empty($this->first_name) ? $this->first_name : null,
            "category" => $this->request->category->title ?? null,
            "sub_category" => $this->request->sub_category->title ?? null,
            "item" => $this->request->item->title ?? null,
            "demanded_qty" => $this->request->demanded_qty ?? null,
            "deadline" => $this->request->deadline ?? null,
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

        if(count($this->userEmails) > 0) {
            Mail::to($this->email)->bcc($this->userEmails)->send(new RequestOfferingProductMail($content, $emailTemplate));
        } else {
            Mail::to($this->email)->send(new RequestOfferingProductMail($content, $emailTemplate));
        }
    }
}
