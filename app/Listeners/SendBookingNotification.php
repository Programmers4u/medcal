<?php

namespace App\Listeners;

use App\Events\NewAppointmentWasBooked;
use App\Events\Event;
use App\Models\User;
use App\TG\TransMail;
use Fenos\Notifynder\Facades\Notifynder;
use Timegridio\Concierge\Models\Contact;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Timegridio\Concierge\Models\Business;

class SendBookingNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private $transmail;

    public function __construct(TransMail $transmail)
    {
        $this->transmail = $transmail;
    }

    public function handle(NewAppointmentWasBooked $event)
    {
        logger()->debug(__METHOD__);
        
        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        Notifynder::category('appointment.reserve')
                   ->from('App\Models\User', $event->user->id)
                   ->to('Timegridio\Concierge\Models\Business', $event->appointment->business->id)
                   ->url('http://localhost')
                   ->extra(compact('businessName', 'code', 'date'))
                   ->send();

        if ($event->appointment->business->pref('disable_outbound_mailing')) {
            $store = "disable_outbound_mailing";
            logger()->debug($store);
            return;
        }
        
        $app_date = new Carbon($event->appointment->start_at, $event->appointment->business->timezone);
        logger()->debug('TS:'.$app_date->toDateTimeString());
        
        if($app_date->timestamp < Carbon::now()->setTimezone($event->appointment->business->timezone)->timestamp) {
            logger()->debug('Data mniejsza od teraźniejszej: '.$app_date->toDateTimeString());
            // return;
        }
        
        /////////////////
        // Send sms    //
        /////////////////

        $this->sendSMSToContactUser($event);
                
        /////////////////
        // Send emails //
        /////////////////

        $this->sendEmailToContactUser($event);

        // $this->sendEmailToOwner($event);
        
    }

    protected function sendSMSToContactUser(Event $event) {
        
        logger()->debug('start sending sms');

        $code = $event->appointment->code;
        $date = $event->appointment->start_at->toDateString();
        $businessName = $event->appointment->business->name;

        $phone = $event->appointment->contact->mobile;
        $message = $event->appointment->business->pref('sms_message');
        $date = $event->appointment->start_at->setTimezone($event->appointment->business->timezone);
        $day = $date->format('Y-m-d');
        $hour = $date->format('H:i');
        $message = str_replace("%day%", $day, $message);        
        $message = str_replace("%hour%", $hour, $message);        
        $message = str_replace("%name%", $businessName, $message);    
        $message = str_replace("%client%", $event->appointment->contact->firstname.' '.$event->appointment->contact->lastname, $message);    
                
        $contactsWithMessage = [[
            'message' => $message,
            'mobile' => $phone
        ]];

        $result = SmsService::sendMessage($contactsWithMessage, $event->appointment->business );
                
        logger()->debug('stop sending sms: ' . json_encode($result));
        
    }
    
    protected function sendEmailToContactUser(Event $event)
    {
        logger()->debug('start sending email');

        if (!$user = $event->user) {
            logger()->debug('not user');
            return false;
        }

        $destinationEmail = $this->getDestinationEmail($user, $event->appointment->contact);

        $params = [
            'user'        => $user,
            'appointment' => $event->appointment,
            'userName'    => $event->appointment->contact->firstname,
        ];
        $header = [
            'name'  => $event->appointment->contact->firstname,
            'email' => $destinationEmail,
        ];
        $email = [
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->appointment->business->locale,
            'timezone' => $user->pref('timezone'),
            'template' => 'user.appointment-notification.notification',
            'subject'  => 'user.appointment-notification.subject',
        ];
        $this->sendemail($email);
    }

    protected function sendEmailToOwner($event)
    {
        $params = [
            'user'        => $event->appointment->business->owner(),
            'appointment' => $event->appointment,
            'ownerName'   => $event->appointment->business->owner()->name,
        ];
        $header = [
            'name'  => $event->appointment->business->owner()->name,
            'email' => $event->appointment->business->owner()->email,
        ];
        $email = [
            'header'   => $header,
            'params'   => $params,
            'locale'   => $event->appointment->business->locale,
            'timezone' => $event->appointment->business->owner()->pref('timezone'),
            'template' => 'manager.appointment-notification.notification',
            'subject'  => 'manager.appointment-notification.subject',
        ];
        $this->sendemail($email);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function sendEmail($email)
    {
        logger()->debug('send email');

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
