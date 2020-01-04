<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\TG\Business\Token as BusinessToken;
use JavaScript;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;

class BusinessAgendaController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $concierge;

    /**
     * Create controller.
     *
     * @param Timegridio\Concierge\Concierge
     */
    public function __construct(Concierge $concierge)
    {
        $this->concierge = $concierge;

        parent::__construct();
    }

    /**
     * get Index.
     *
     * @param Business $business Business to get agenda
     *
     * @return Response Rendered view of Business agenda
     */
    public function getIndex(Business $business)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);

        $status = 'unserved';
        switch ($status){
            case 'active' : 
                $appointments = $this->concierge->business($business)->getActiveAppointments();
            break;
            case 'unserved' : 
                $appointments = $this->concierge->business($business)->getUnservedAppointments();
            break;
            default:
                $appointments = $this->concierge->business($business)->getUnarchivedAppointments();
        }

        $viewKey = count($appointments) == 0
            ? 'manager.businesses.appointments.empty'
            : "manager.businesses.appointments.{$business->strategy}.index";

        $user = auth()->user();
        return view($viewKey, compact('business', 'appointments', 'user'));
    }

    public function getCalendar(Business $business, $hr=null)
    {
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));
        
        $requestst = json_encode($hr);
        
        $this->authorize('manage', $business);

        //$appointments = $this->concierge->business($business)->getActiveAppointments();
        //$appointments = $this->concierge->business($business)->getUnarchivedAppointments();
        $start_at = \Carbon\Carbon::createFromTimestamp(time());
        $where_at = \Carbon\Carbon::parse($start_at,$business->timezone)->addDays(-7);
        $where_to = \Carbon\Carbon::parse($start_at,$business->timezone)->addDays(7);
        $appointments = \Timegridio\Concierge\Models\Appointment::query()->where('start_at','>=', $where_at)->where('start_at','<=',$where_to)->limit(150)->get();        
        
        logger()->debug($appointments);

        $jsAppointments = [];

        foreach ($appointments as $appointment) {
            $staff = \Timegridio\Concierge\Models\Humanresource::query()->find($appointment->humanresource_id);
            $leaf = \App\Models\MedicalHistory::getHistory($appointment->contact->id);
            $leaf = ($leaf->total()==0) ? 'leaf' : '';

            $sun = \App\Models\MedicalHistory::query()->where('appointment_id', '=',$appointment->id)->get()->count();
            $sun = ($sun==0) ? 'frown-o' : 'smile-o';

            //if(!isset($staff->color)) return redirect()->route('manager.business.humanresource.index',[$business]);
            
            $jsAppointments[] = [
                'id'    => $appointment->id,
                'title' => $appointment->contact->lastname.' '.$appointment->contact->firstname.' '.$appointment->contact->mobile.' ',
                'color' => (isset($staff->color)) ? $staff->color : '',
                'start' => $appointment->start_at->timezone($business->timezone)->toIso8601String(),
                'end'   => $appointment->finish_at->timezone($business->timezone)->toIso8601String(),
                'service' => $appointment->service->name,
                'staff' => (isset($staff->name)) ? $staff->name : '',
                'phone' => $appointment->contact->mobile,
                'icon'  => $leaf,
                'icon2'  => $sun,
            ];
        }

        $holiDays = \App\Http\Controllers\API\BookingController::freeDays();
        foreach($holiDays as $hd) {
            $jsAppointments[] = $hd;
        }
        
        $slotDuration = count($appointments) > 5 ? '0:15' : '0:30';

        $icalURL = $this->generateICalURL($business);

        unset($appointments);
        
        $preferences = $business->preferences;

        if(count($preferences)==0){
            flash()->warning('Brak ustawień, zapisz swoje ustawienia!');
            return redirect()->route('manager.business.preferences', $business);
        };
        JavaScript::put([
            'minTime'      => $business->pref('start_at'),
            'maxTime'      => $business->pref('finish_at'),
            'events'       => $jsAppointments,
            'lang'         => $this->getActiveLanguage($business->locale),
            'slotDuration' => $slotDuration,
            'serviceDuration' => $preferences[13]->value,
        ]);
        
        $contacts = $business->addressbook()->listing(1);
        $humanresources = $business->humanresources;
        $services = $business->services;
        $AktCalendarHr = ($hr!=null) 
                ? $business->humanresources()->getQuery()->find($hr)->toArray()
                : ['name'=>'All'];
        
        $contact = new Contact();

        return view('manager.businesses.appointments.calendar', compact('contact','AktCalendarHr','business', 'icalURL', 'contacts','humanresources','requestst', 'services'));
    }

    protected function getActiveLanguage($locale)
    {
        return session()->get('language', substr($locale, 0, 2));
    }

    protected function generateICalURL(Business $business)
    {
        $businessToken = new BusinessToken($business);

        return route('business.ical.download', [$business, $businessToken->generate()]);
    }
}
