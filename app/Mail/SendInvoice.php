<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    private string $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->attachment){
            
            $location = Storage::disk('local')->path($this->attachment);
            $response = $this->markdown('emails.invoice')->attach($location);
        }else
            $response = $this->markdown('emails.invoice');

        return $response;
        // ->attach($location)
    }
}
