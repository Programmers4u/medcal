<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Timegridio\Concierge\Models\Contact;


use App\Events\NewAppointmentWasBooked;
use App\Events\NewSoftAppointmentWasBooked;
use Event;
use Notifynder;
use Timegridio\Concierge\Exceptions\DuplicatedAppointmentException;

use Timegridio\Concierge\Booking\BookingManager;
use Timegridio\Concierge\Calendar\Calendar;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Service;
use Timegridio\Concierge\Timetable\Strategies\TimetableStrategy;
use Timegridio\Concierge\Vacancy\VacancyManager;

class AroundBusinessController extends Controller
{
    public function getAppointments(Request $request, $business_id) {

        if(!$business_id) return response()->json(['error'=>'not business']);

        $business = Business::find($business_id);

        $this->authorize('manage', $business);

        $appoStaff = \Timegridio\Concierge\Models\Appointment::query()
               ->where('business_id','=',$business->id)
               //->where('humanresources_id','=',1)
               ->where('start_at','>', \Carbon\Carbon::today()->timezone($business->timezone)) 
               ->where('start_at','<', \Carbon\Carbon::tomorrow()->timezone($business->timezone)) 
               ->whereIn('status',['C','R'])
               ->orderBy('start_at','ASC')
               ->get();

        $agenda = [];
        foreach($appoStaff as $ag){
            $staff = \Timegridio\Concierge\Models\Humanresource::query()
                    ->where('id','=',$ag->humanresource_id)
                    ->where('business_id','=',$business->id)
                    ->get();
            
            $staff->name = (empty($staff[0]->name)) ? '' : $staff[0]->name;
            $userApp = Contact::query()->where('id','=',$ag->contact_id)->get();

            $contactName = $userApp[0]->firstname.' '.$userApp[0]->lastname;

            $date = \Carbon\Carbon::parse($ag->start_at)->timezone($business->timezone)->format('H:i');
            //$date = $date->hour.':'.$date->minute;
            
            $rec = [
                'id'=>$ag->id,
                'start_at'=>$date,
                'staff'=>$staff->name,
                'staff_id'=>$ag->humanresource_id,
                'contact_name'=>$contactName,
            ];
            array_push($agenda, $rec);
        };

        return response()->json($agenda);

    }
}
