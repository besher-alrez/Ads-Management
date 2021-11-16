<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdvertismentReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    private $advertisers;
    /**
     * @var array
     */
    

   
    public function __construct($advertisers = [])
    {
        $this->advertisers = $advertisers;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('mails.advertisment_reminder.subject'))
            //->markdown('emails.certificate_expiry')
            ->view('emails.advertisment_reminder')
            ->with('advertisers', $this->advertisers)
    }
}
