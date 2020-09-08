<?php

namespace App\Services;

use Timegridio\Concierge\Models\Contact;
use Carbon\Carbon;
use Timegridio\Concierge\Models\Business;

use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Programmers4u\gatesms\sms\sender\SmsSender;

class SmsService
{
    //
    
    public function index(){
        
    }
    
    public static function sendMessage($contactsWithMessage, Business $business){
        
        $preferences = $business->preferences;
        
        if ($business->pref('disable_outbound_mailing')) {
            $store = "disable_outbound_mailing\r\n";
            logger()->debug($store);
            SmsService::pushReport($store);
            return [];
        }
        
        $sms = new smsSender();
        $login = ($business->pref('sms_id')) ? $business->pref('sms_id') : env('SMS_ID','');
        $pass = ($business->pref('sms_secret')) ? $business->pref('sms_secret') : env('SMS_SECRET','');
        $self_number = ($business->pref('sms_self_number')) ? $business->pref('sms_self_number') : env('SMS_SELF_NUMBER','');
        $sms->setLogin($login);
        $sms->setPass($pass);
        $sms->setTest(env('SMS_TEST',1));
        $sms->setFrom(env('SMS_FROM',''));
        $sms->setSelfNumber($self_number);
        $results = [];
        foreach($contactsWithMessage as $cwm){
            $sms->setMsg($cwm['message']);
            $sms->setTo($cwm['mobile']);
            $result = $sms->sendSms();    
            array_push($results, $result);
            
            $number = $cwm['mobile'];
            $message = $cwm['message'];
            Notifynder::category('sms.send')
                       ->from('App\SmsService', 0)
                       ->to('App\SmsService', 0)
                       ->url('http://localhost')
                       ->extra(compact('number', 'message'))
                       ->send();
        };
        
        $store = 'sendMessage: '.date('d/m/Y H:i:s')."\r\n";
        foreach($results as $result) {
            $store.= 'Report: '.$result."\r\n";
        }
        logger()->debug($store);
        SmsService::pushReport($store);

        // Generate local notification
        Notifynder::category('sms.send')
            ->from('App\SmsService', 0)
            ->to('App\SmsService', 0)
            ->url('http://localhost')
            ->extra(compact('store'))
            ->send();

        return $results;
    }
    
    public function putMessage(){
        return 'Zaslepka: putMessage()';
    }
    
    public function getMessage(){
        return 'Zaslepka: getMessage()';
    }
    
    private static function getBody($rows = null, $messageId = null){
        
        if($rows === null || $messageId === null) {return [];}
        $response = [];
        foreach($rows as $row){
            $record = ['name'=>'','mobile'=>'','appointment_id'=>'','contact_id'=>'', 'message'=>'', 'business'=>''];
            $business = Business::where('id','=',$row->business_id)->first();
            $record['business'] = $business;
            $record['appointment_id'] = $row->id;
            $record['contact_id'] = $row->contact_id;
            $contact = Contact::query(['firstname','lastname','mobile'])
                    ->leftJoin("med_permission", "contact_id","=","contacts.id")
                    ->where('contacts.id','=', $row->contact_id)
                    ->where('appo_sms','=','1')
                    ->first()
                    //->get()
                    ;
            if ($contact === null) {
                continue;
            }
            $record['can_sms'] = TRUE;

            $record['name'] = $contact->firstname;
            $record['mobile'] = $contact->mobile;

            $message = $business->pref($messageId);
            if (empty($message)) {
                continue;
            }
            $date = $row->start_at->setTimezone($business->timezone);
            $day = $date->format('Y-m-d');
            $hour = $date->format('H:i');
            $message = str_replace("%day%", $day, $message);        
            $message = str_replace("%hour%", $hour, $message);        
            $message = str_replace("%name%", $business->name, $message);    
            $message = str_replace("%client%", $contact->firstname.' '.$contact->lastname, $message);    
            $record['message'] = $message;
            
            $can = \App\Models\MedPermission::where('contact_id','=',$row->contact_id)->first();
            $record['can_sms'] = (null==$contact->appo_sms) ? FALSE : TRUE;
            array_push($response,$record);
        }
        $out = [];
        $store = 'SendReminderSms start at:'.date('d/m/Y H:i:s')."\r\n";
        foreach ($response as $m){
            $record['mobile'] = $m['mobile'];
            $record['message'] = $m['message'];
            $result = SmsService::sendMessage([$record], $m['business']);
            array_push ($out, $result);
            $store.= json_encode($record)."\r\n";
        }
        $store.= json_encode($out)."\r\n";
        SmsService::pushReport($store);
        return $out;
    }

    /**
     * Get available appointments from now to 1 day forward
     * @param type $message
     * @return array
     */
    public static function getNow(){
        // all business messages send
        $rows = \Timegridio\Concierge\Models\Appointment::query()
                ->where('start_at','>', Carbon::parse()->addDay(0)->toIso8601String())
                ->where('start_at','<', Carbon::parse()->addDays(1)->toIso8601String())
                ->get()
                ;
        return SmsService::getBody($rows,'sms_message');
        
    }
    
    protected function getMessageTemplate(){
        
    }

    public static function getTomorrow(){
        /**
         *  all business messages send
         */
        $rows = \Timegridio\Concierge\Models\Appointment::query()
                ->where('start_at','>', Carbon::parse()->addDays(1)->toIso8601String())
                ->where('start_at','<', Carbon::parse()->addDays(2)->toIso8601String())
                ->get()
                ;
        return SmsService::getBody($rows,'sms_message1');
    }

    protected function getWeek(){
        
    }
    
    protected function getThreeMonth(){
        
    }

    public static function getSixMonth(){
        /**
         *  all business messages send
         */
        $rows = \Timegridio\Concierge\Models\Appointment::query()
                ->where('finish_at','>', Carbon::parse()->addDays(-181)->toIso8601String())
                ->where('finish_at','<', Carbon::parse()->addDays(-180)->toIso8601String())
                ->orderBy('finish_at','desc')
                ->get()
                ;
        
        $filtr_rows = [];
        foreach ($rows as $row){
            $business = Business::where('id','=',$row->business_id)->first();
            $can = \App\Models\MedPermission::query('appo_sms_sent')
                    ->where('business_id','=',$row->business_id)
                    ->where('contact_id','=',$row->contact_id)
                    ->first();
            if($can['appo_sms_sent']===FALSE) {
                array_push ($filtr_rows, $row);
                DB::table('med_permission')
                        ->where('contact_id','=',$row->contact_id)
                        ->update(['appo_sms_sent'=>TRUE]);
            }
        }
        
        return SmsService::getBody($filtr_rows,'sms_message2');
        
    }
    
    protected static function pushReport($params) {
        checkDir('storage/logs');
        $path = storage_path('').'/logs/sms_report.txt';
        file_put_contents($path,$params,FILE_APPEND);
        //Storage::disk('local')->append('logs/sms_report.txt', $params);
    }
}
