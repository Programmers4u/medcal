<?php

namespace App\Listeners;

use App\Events\AppointmentWasChange;
use App\Events\Event;
use App\Models\User;
use App\Services\SmsService;
use App\TG\TransMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Timegridio\Concierge\Models\Contact;

class SendAppointmentChangeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private $transmail;

 
    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    public function handle(AppointmentWasChange $event)
    {
        // logger()->info(__METHOD__);
        
        if ($event->appointment->business->pref('disable_outbound_mailing')) {
            return;
        }

        /////////////////
        // Send emails //
        /////////////////

        $this->sendEmailToContactUser($event);

        /////////////////
        // Send sms //
        /////////////////

        $this->sendSMSToContactUser($event);

    }

    protected function sendSMSToContactUser(Event $event) {
        
        // logger()->debug('start sending sms');

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        $phone = $event->appointment->contact->mobile;
        $message = $event->appointment->business->pref('sms_message4');
        $date = $event->appointment->start_at->setTimezone($event->appointment->business->timezone);
        $day = $date->format('Y-m-d');
        $hour = $date->format('H:i');
        $message = str_replace("%day%", $day, $message);        
        $message = str_replace("%hour%", $hour, $message);        
        $message = str_replace("%name%", $businessName, $message);    
        $message = str_replace("%client%", $event->appointment->contact->firstname.' '.$event->appointment->contact->lastname, $message);    

        // if (!$user = $event->appointment->contact->user) {
        //    return false;
        // }
                
        $contactsWithMessage = [[
            'message' => $message,
            'mobile' => $phone
        ]];

        $result = SmsService::sendMessage($contactsWithMessage, $event->appointment->business);
                
        // logger()->debug('stop sending sms: ' . json_encode($result));
        
    }

    protected function sendEmailToContactUser($event)
    {        
        if (!$user = $event->user) {
            return false;
        }

        $destinationEmail = $this->getDestinationEmail($user, $event->appointment->contact);
        if(!$destinationEmail) return false;

        // Mail to User
        $params = [
            'user'         => $event->user,
            'appointment'  => $event->appointment,
            'userName'     => $event->appointment->contact->firstname,
            'businessName' => $event->appointment->business->name,
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $destinationEmail,
        ];

        $email = [
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->appointment->business->locale,
            'timezone' => $event->user->pref('timezone'),
            'template' => 'user.appointment-change.notification',
            'subject'  => 'user.appointment-changing.subject',
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

    protected function getDestinationEmail(User $user, Contact $contact)
    {
        return $contact->email ?: $user->email;
    }

}
