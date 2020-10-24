<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class SendMedicalHistoryPdf extends Event
{
    use SerializesModels;

    public $business;
    public $contact;
    public $pathFile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, Business $business, $pathFile)
    {
        $this->contact = $contact;
        $this->business = $business;
        $this->pathFile = $pathFile;
    }
}
