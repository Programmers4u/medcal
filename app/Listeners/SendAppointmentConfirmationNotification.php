<?php

namespace App\Listeners;

use App\Events\AppointmentWasConfirmed;
use App\Events\Event;
use App\Services\SmsService;
use App\TG\TransMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppointmentConfirmationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    /**
     * Handle the event.
     *
     * @param AppointmentWasConfirmed $event
     *
     * @return void
     */
    public function handle(AppointmentWasConfirmed $event)
    {
        // logger()->info(__METHOD__);

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        if ($event->appointment->business->pref('disable_outbound_mailing')) {
            return;
        }

        /////////////////
        // Send emails //
        /////////////////

        // Mail to User
        $params = [
            'user'         => $event->user,
            'appointment'  => $event->appointment,
            'userName'     => $event->appointment->contact->firstname,
            'businessName' => $businessName,
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $event->appointment->contact->email,
        ];
        $this->transmail->locale($event->appointment->business->locale)
                        ->timezone($event->user->pref('timezone'))
                        ->template('user.appointment-confirmation.notification')
                        ->subject('user.appointment-confirmation.subject', compact('businessName'))
                        ->send($header, $params);

        $this->sendSMSToContactUser($event);
    }

    protected function sendSMSToContactUser(Event $event) {
        
        // logger()->debug('start sending sms');

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        $phone = $event->appointment->contact->mobile;
        $message = $event->appointment->business->pref('sms_message1');
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

}
