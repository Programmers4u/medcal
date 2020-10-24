<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\TG\Business\Token as BusinessToken;
use JavaScript;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use \Carbon\Carbon;
use \Timegridio\Concierge\Models\Appointment;
use \Timegridio\Concierge\Models\Humanresource;
use \App\Models\MedicalHistory;
use \App\Http\Controllers\API\BookingController;
use App\Http\Requests\Request;
use App\Models\Notes;

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
        // logger()->info(__METHOD__);
        // logger()->info(sprintf('businessId:%s', $business->id));

        $this->authorize('manage', $business);
        
        switch (request()->input('status')) {
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
        // logger()->info(__METHOD__);
        // logger()->info(sprintf('businessId:%s', $business->id));
        
        // $hr = json_encode($hr);
        
        $this->authorize('manage', $business);

        //$appointments = $this->concierge->business($business)->getActiveAppointments();
        //$appointments = $this->concierge->business($business)->getUnarchivedAppointments();
        $start_at = Carbon::createFromTimestamp(time());
        $where_at = Carbon::parse($start_at,$business->timezone)->addDays(-7);
        $where_to = Carbon::parse($start_at,$business->timezone)->addDays(7);
        $appointments = Appointment::query()
            ->where('business_id','=',$business->id)
            ->where('start_at','>=', $where_at)
            ->where('start_at','<=',$where_to)
            ->where(function($q) {
                $q
                ->where('status', \Timegridio\Concierge\Models\Appointment::STATUS_CONFIRMED)
                ->orWhere('status', \Timegridio\Concierge\Models\Appointment::STATUS_RESERVED)
                ->orWhere('status', \Timegridio\Concierge\Models\Appointment::STATUS_SERVED)
                ;
            })
            ->limit(150)
            ->get();        
        
        // logger()->debug($appointments);

        $jsAppointments = [];

        foreach ($appointments as $appointment) {
            $staff = Humanresource::find($appointment->humanresource_id);
            $leaf = MedicalHistory::getHistory($appointment->contact->id);
            $leaf = ($leaf->total()==0) ? 'leaf' : '';

            $sun = MedicalHistory::query()->where('appointment_id', '=',$appointment->id)->get()->count();
            $sun = ($sun==0) ? 'frown-o' : 'smile-o';

            //if(!isset($staff->color)) return redirect()->route('manager.business.humanresource.index',[$business]);

            $note = Notes::getNote($appointment->id);
            $notes = '';
            if($note) {
                $notes = null;
                $note->map(function($item) use (&$notes) {
                    $notes.= $item . "\n"; 
                });        
            };

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
                'icon4' => $note,
            ];
        }

        $holliDays = BookingController::freeDays();
        foreach($holliDays as $holliDay) {
            $jsAppointments[] = $holliDay;
        }
        
        $slotDuration = count($appointments) > 5 ? '0:15' : '0:30';

        $icalURL = $this->generateICalURL($business);

        unset($appointments);
        
        $preferences = $business->preferences;

        if(count($preferences)===0){
            flash()->warning('Brak ustawień, zapisz swoje ustawienia!');
            return redirect()->route('manager.business.preferences', $business);
        };
        
        JavaScript::put([
            'minTime'      => $business->pref('start_at'),
            'maxTime'      => $business->pref('finish_at'),
            'events'       => $jsAppointments,
            'lang'         => $this->getActiveLanguage($business->locale),
            'slotDuration' => $slotDuration,
            'serviceDuration' => is_array($preferences) ? $preferences[13]->value : 0,
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
