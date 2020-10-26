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
use App\Models\MedicalTemplates;
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

        $this->authorize('manage', $business);

        $date = request()->input('date');
        $status = request()->input('status');
        
        $appointments = Appointment::query()
               ->where('business_id','=',$business->id)
            ;

        switch($date) {
            case 'tomorrow' : $appointments
                ->where('start_at','>', Carbon::now()->addDay()->startOfDay());
            break; 
            case 'today' : 
                $appointments
                ->where('start_at','>', Carbon::now()->startOfDay())
                ->where('start_at','<', Carbon::now()->addDay()->startOfDay())
                ;
            break;
            default : 
                // $appointments
                // ->where('start_at','>', Carbon::now()->startOfDay())
                // ->where('start_at','<', Carbon::now()->addDay()->startOfDay())
                // ;
            break; 
        }
        
        switch($status) {
            case 'active' : 
                $appointments->whereIn('status', ['C']);
            break;
            case 'unserved' : 
                $appointments->whereIn('status', ['A']);
            break;
            case 'reserv' : 
                $appointments->whereIn('status', ['R']);
            break;
            case 'served' : 
                $appointments->whereIn('status', ['S']);
            break;
            default:
                $appointments->whereIn('status', ['A','R','C']);
        }
        // dd($appointments->get());

        $appointments = $appointments->with('contact')->orderBy('start_at','ASC')->get();
        $viewKey = count($appointments) == 0
            ? 'manager.businesses.appointments.empty'
            : "manager.businesses.appointments.{$business->strategy}.index";

        $user = auth()->user();
        return view($viewKey, compact('business', 'appointments', 'user'));
    }

    public function getCalendar(Business $business, $hr=null)
    {
        
        $this->authorize('manage', $business);

        $preferences = $business->preferences;

        if(count($preferences)===0){
            flash()->warning('Brak ustawień, zapisz swoje ustawienia!');
            return redirect()->route('manager.business.preferences', $business);
        };

        if(Humanresource::where('business_id', $business->id)->get()->count() === 0){
            flash()->warning('Brak specjalistów');
            return redirect()->route('manager.business.humanresource.index', $business);
        };

        // if(MedicalTemplates::where('business_id', $business->id)->get()->count() === 0){
        //     flash()->warning('Brak specjalistów');
        //     return redirect()->route('medical.template.index', $business);
        // };

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
                ->where('status', Appointment::STATUS_CONFIRMED)
                ->orWhere('status', Appointment::STATUS_RESERVED)
                ;
            })
            ->limit(150)
            ->get();        
        
        $jsAppointments = [];

        foreach ($appointments as $appointment) {
            $staff = Humanresource::find($appointment->humanresource_id);
            $leaf = MedicalHistory::getHistory($appointment->contact->id);
            $leaf = ($leaf->total()==0) ? 'leaf' : '';

            $sun = MedicalHistory::query()->where('appointment_id', '=',$appointment->id)->get()->count();
            $sun = ($sun==0) ? 'frown-o' : 'smile-o';

            //if(!isset($staff->color)) return redirect()->route('manager.business.humanresource.index',[$business]);

            $note = Notes::getNote($appointment->id, $business->id, $appointment->contact_id);
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
