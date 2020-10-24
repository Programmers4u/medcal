<?php

namespace App\Listeners;

use App\Events\Event;
use App\Events\GenerateMedicalHistoryPdf;
use App\Models\User;
use App\TG\TransMail;
use Timegridio\Concierge\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateMedicalHistoryPdfNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    public function handle(GenerateMedicalHistoryPdf $event)
    {
        // $this->sendEmailToContact($event);
        $this->sendEmailToOwner($event);
    }
    
    protected function sendEmailToContact(Event $event)
    {

        // if (!$user = $event->user) {
        //     // logger()->debug('not user');
        //     return false;
        // }

        // $params = [
        //     'user'        => $user,
        //     'appointment' => $event->appointment,
        //     'userName'    => $event->appointment->contact->firstname,
        //     'businessName' => $event->appointment->business->name,
        // ];
        // $header = [
        //     'name'  => $event->appointment->contact->firstname,
        //     'email' => $destinationEmail,
        // ];
        // $email = [
        //     'header'   => $header,
        //     'params'   => $params,
        //     'locale'   => $event->appointment->business->locale,
        //     'timezone' => $user->pref('timezone'),
        //     'template' => 'user.appointment-notification.notification',
        //     'subject'  => 'user.appointment-notification.subject',
        // ];
        // $this->sendemail($email);
    }

    protected function sendEmailToOwner($event)
    {
        $params = [
            'user'        => $event->business->owner(),
            // 'appointment' => $event->appointment,
            'ownerName'   => $event->business->owner()->name,
        ];
        $header = [
            'name'  => $event->business->owner()->name,
            'email' => $event->business->owner()->email,
            'filePathName' => $event->pathFile,
        ];
        $email = [
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->business->locale,
            'timezone' => $event->business->owner()->pref('timezone'),
            'template' => 'manager.medical-history-notification.notification',
            'subject'  => 'manager.appointment-notification.subject',
            
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
                        ->send($header, $params);
    }
}
