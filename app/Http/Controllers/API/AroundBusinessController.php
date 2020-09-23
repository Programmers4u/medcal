<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Timegridio\Concierge\Models\Contact;
use Timegridio\Concierge\Models\Business;
use \Timegridio\Concierge\Models\Appointment;
use \Timegridio\Concierge\Models\Humanresource;
use \Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AroundBusinessController extends Controller
{
    public function getAppointments(Request $request, $business_id) : JsonResponse 
    {
        if(!$business_id) return response()->json(['error'=>'not business']);

        $business = Business::find($business_id);

        $this->authorize('manage', $business);

        $toDay = Carbon::now()->startOfDay();
        $endDay = $toDay->copy()->endOfDay();

        //logger()->debug(json_encode($toDay));
        //logger()->debug(json_encode($toMorrow));

        $appoStaff = Appointment::query()
               ->where('business_id','=',$business->id)
               ->where('start_at','>', $toDay) 
               ->where('start_at','<', $endDay) 
            //    ->whereIn('status',['C','R'])
               ->orderBy('start_at','ASC')
               ->get();

        $agenda = [];
        foreach($appoStaff as $ag){
            $staff = Humanresource::query()
                    ->where('id','=',$ag->humanresource_id)
                    ->where('business_id','=',$business->id)
                    ->get();
            
            $staff->name = (empty($staff[0]->name)) ? '' : $staff[0]->name;
            $userApp = Contact::query()->where('id','=',$ag->contact_id)->get();

            $contactName = $userApp[0]->firstname.' '.$userApp[0]->lastname;

            $date = Carbon::parse($ag->start_at)->timezone($business->timezone)->format('H:i');
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
