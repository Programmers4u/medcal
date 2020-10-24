<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\SendMedicalHistoryPdf;
use App\TG\TransMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMedicalHistoryPdfNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    public function handle(SendMedicalHistoryPdf $event)
    {
        $this->sendEmailToContact($event);
        $this->sendEmailToOwner($event);
    }
    
    protected function sendEmailToContact(Event $event)
    {

        $destinationEmail = $event->contact->email;
        if(empty($destinationEmail)) return;

        $params = [
            'user'        => $event->contact->firstname,
            'ownerName'    => $event->contact->firstname,
        ];
        $header = [
            'name'  => $event->contact->firstname,
            'email' => $destinationEmail,
        ];
        $email = [
            'filePathName' => [$event->pathFile],
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->business->locale,
            'timezone' => $event->business->owner()->pref('timezone'),
            'template' => 'manager.medical-history-notification.notification',
            'subject'  => 'manager.medical-document-notification.subject',
        ];
        $this->sendemail($email);
    }

    protected function sendEmailToOwner($event)
    {
        $params = [
            'user'        => $event->business->owner(),
            'ownerName'   => $event->business->owner()->name,
        ];
        $header = [
            'name'  => $event->business->owner()->name,
            'email' => $event->business->owner()->email,
        ];
        $email = [
            'filePathName' => [$event->pathFile],
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->business->locale,
            'timezone' => $event->business->owner()->pref('timezone'),
            'template' => 'manager.medical-history-notification.notification',
            'subject'  => 'manager.medical-document-notification.subject',
        ];
        $this->sendemail($email);
    }

    protected function sendEmail($email)
    {
        extract($email);

        $this->transmail->locale($locale)
                        ->timezone($timezone)
                        ->template($template)
                        ->subject($subject)
                        ->attach($filePathName)
                        ->send($header, $params);
    }
}
