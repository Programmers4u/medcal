<?php

namespace App\Http\Controllers\API;

use App\Events\AppointmentWasCanceled;
use App\Events\AppointmentWasConfirmed;
use App\Events\NewAppointmentWasBooked;
use App\Events\NewSoftAppointmentWasBooked;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlterAppointmentRequest;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Appointment;
use Timegridio\Concierge\Models\Business;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Timegridio\Concierge\Models\Contact;

use \Timegridio\Concierge\Models\Humanresource;
use \App\Models\MedicalHistory;
use \App\Models\MedicalFile;

use App\Http\Consts\ResponseApi;
use App\Http\Requests\Appointments\BookingChangeRequest;
use App\Http\Requests\Appointments\BookingRequest;
use App\Models\Notes;
use Event;
use Illuminate\Http\JsonResponse;
use Notifynder;
use Timegridio\Concierge\Exceptions\DuplicatedAppointmentException;

use Timegridio\Concierge\Booking\BookingManager;
use Timegridio\Concierge\Calendar\Calendar;
use Timegridio\Concierge\Models\Service;
use Timegridio\Concierge\Timetable\Strategies\TimetableStrategy;
use Timegridio\Concierge\Vacancy\VacancyManager;

use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Concierge service implementation.
     *
     * @var Timegridio\Concierge\Concierge
     */
    private $concierge;

    protected $timetable = null;

    protected $calendar = null;

    protected $booking = null;

    protected $vacancies = null;

    protected $appointment = null;

    protected $business = null;
    
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
     * post Action for booking.
     *
     * @param AlterAppointmentRequest $request
     *
     * @return JSON Action result object
     */
    public function postAction(AlterAppointmentRequest $request)
    {
        logger()->info(__METHOD__);
        
        $isuser = auth()->user();
        $business = Business::findOrFail($request->input('business'));
        $appointment = Appointment::findOrFail($request->input('appointment'));
        $action = $request->input('action');
        $widgetType = $request->input('widget');
        
        /////////////////////////////////////////////
        // AUTHORIZATION : AlterAppointmentRequest //
        /////////////////////////////////////////////
        //  (A) auth()->user() is owner of $business
        // OR
        //  (B) auth()->user() is issuer of $appointment

        logger()->info(sprintf(
            'postAction.request:[issuer:%s, action:%s, business:%s, appointment:%s]',
            $isuser->email,
            $action,
            $business->id,
            $appointment->id
        ));

        $this->concierge->business($business);
        
        $appointmentManager = $this->concierge->booking()->appointment($appointment->hash);
        
        switch ($action) {
            case 'cancel':
                // $app = Appointment::find($appointment->id);
                // $app->delete();
                $appointment = $appointmentManager->cancel();
                event(new AppointmentWasCanceled($isuser, $appointment));
                break;
            case 'confirm':
                $appointment = $appointmentManager->confirm();
                event(new AppointmentWasConfirmed($isuser, $appointment));
                break;
            case 'serve':
                $appointment = $appointmentManager->serve();
                break;
            default:
                # code...
                break;
        }

        $contents = [
            'appointment' => $appointment->load('contact'),
            'user'        => auth()->user(),
            ];

        $viewKey = "widgets.appointment.{$widgetType}._body";
        // Widgets MUST be rendered before being returned on Response as they need to be interpreted as HTML
        $html = view($viewKey, $contents)->render();
        $code = 'OK';

        logger()->info("postAction.response:[appointment:{$appointment->toJson()}]");

        return response()->json(compact('code', 'html'));
    }
    
    protected function findSubscrbedContact($isuser, $isOwner, Business $business, $contactId)
    {
        if ($contactId && $isOwner) {
            return $business->contacts()->find($contactId);
        }

        return $isuser->getContactSubscribedTo($business->id);
    }
    
    
    public function postBooking(BookingRequest $request){
        
        logger()->info(__METHOD__);

        //////////////////
        // FOR REFACTOR //
        //////////////////
        
        $business = Business::findOrFail($request->input('businessId'));
        $this->business = $business;
        $email = $request->input('email');
        $contactId = $request->input('contact_id');
        $isOwner = false;

        $issuer = auth()->user();
        
        if ($issuer) {
            $isOwner = $issuer->isOwnerOf($business->id);
            $contact = $this->findSubscrbedContact($issuer, $isOwner, $business, $contactId);
        } else {
            $contact = $this->getContact($business, $email);

            if (!$contact) {
                logger()->info('[ADVICE] Not subscribed');
                flash()->warning(trans('user.booking.msg.store.not-registered'));
                return redirect()->back();
            }

            auth()->once(compact('email'));
        }
        
        // Authorize contact is subscribed to Business
        // ...

        $serviceId = $request->input('service_id');
        $service = $business->services()->find($serviceId);
        
        $_date_start = str_replace(['"','T'],' ',$request->input('_date'));
        $_date_finish = str_replace(['"','T'],' ',$request->input('_finish_date'));
        
        $date_start = Carbon::parse(trim($_date_start))->toDateString();        
        $time_start = Carbon::parse(trim($_date_start))->toTimeString();

        $date_finish = Carbon::parse(trim($_date_finish))->toDateString();        
        $time_finish = Carbon::parse(trim($_date_finish))->toTimeString();

        $timezone = $request->input('_timezone') ?: $business->timezone;

        $comments = $request->input('comments');
        $issuer = auth()->id();

        $humanresource = $request->input('hr');
        $reservation = compact('issuer', 'contact', 'service', 'date_finish', 'time_finish','date_start', 'time_start', 'timezone', 'comments', 'humanresource','business');

        logger()->info('Reservation:'.print_r($reservation, true));

        $startAt = $this->makeDateTimeUTC($date_start, $time_start, $timezone);
        $finishAt = $this->makeDateTimeUTC($date_finish, $time_finish, $timezone);//$startAt->copy()->addMinutes($service->duration);
        
        //if($this->isBookable($startAt,$finishAt) > 0) return response()->json("Nakładające się terminy!");
        if($this->isCollision($startAt,$finishAt,$humanresource,$service->duration)) return response()->json("Nakładające się terminy!");
            
        try {
            
            $appointment = $this->takeReservation($reservation);

        } catch (DuplicatedAppointmentException $e) {

            //$code = $this->concierge->appointment()->code;

            logger()->info("DUPLICATED Appointment with CODE:{$e->getMessage()}");
            return response()->json("DUPLICATED Appointment with CODE:{$e->getMessage()}");
            
            //flash()->warning(trans('user.booking.msg.store.sorry_duplicated', compact('code')));

            if ($isOwner) {
                //return redirect()->route('manager.business.agenda.index', compact('business'));
            }

            //return redirect()->route('user.agenda');
        }

        if (false === $appointment) {
            logger()->info('[ADVICE] Unable to book');

            //flash()->warning(trans('user.booking.msg.store.error'));

            //return redirect()->back();
            return response()->json(trans('user.booking.msg.store.error'));
        }

        logger()->info('Appointment saved successfully');

        //flash()->success(trans('user.booking.msg.store.success', ['code' => $appointment->code]));

        if (!$issuer) {
            event(new NewSoftAppointmentWasBooked($appointment));

            //return view('guest.appointment.show', compact('appointment'));
        }
        
        event(new NewAppointmentWasBooked(auth()->user(), $appointment));

        if ($isOwner) {
            //return redirect()->route('manager.business.agenda.index', compact('business'));
        }

        //return redirect()->route('user.agenda', '#'.$appointment->code);

        /**
         * Save note for appointment
         */
        if($appointment && $request->input('note',null)) {
            Notes::setNote($request->input('note'),$appointment->id);
        };

        return response()->json('Wizyta zapisana.');
    }
    
    public function bookingChange(BookingChangeRequest $request) : JsonResponse {

        $this->business = Business::findOrFail($request->input('businessId'));
        
        $time = $request->input('times');
        $id = $request->input('id');
        $type = $request->input('type');

        $appointment = Appointment::find($id);

        $startAt = $appointment->start_at->copy();
        $finishAt = $appointment->finish_at->copy();
        
        $startAt = Carbon::parse($startAt);
        $finishAt = Carbon::parse($finishAt);

        $time = intval(trim($time,"'"))/1000;

        if($type === 'a' ) {
            $startAt->addSeconds($time);     
            $finishAt->addSeconds($time);                
        } else {
            $finishAt->addSeconds($time);                
        }
                
        $hr = $appointment->humanresource_id;
        $isCollision = $this->isCollision($startAt,$finishAt,$hr,$id);

        $response = ["info"=>"Konflikt z innym terminem",'type'=>'error'];
        if($isCollision === 0) {
            //$query = ['id'=>$id];
            //$update=["start_at"=>$startAt,'finish_at'=>$finishAt];
            //$app = Appointment::find($id);
            $appointment->start_at = $startAt;
            $appointment->finish_at = $finishAt;
            $response = ["info"=>"Termin zmieniony",'type'=>'success'];
            $appointment->save();
            //$response = Appointment::update($query,$update);
            event(new NewAppointmentWasBooked(auth()->user(), $appointment));
        }
        return response()->json([
            'info' => $response['info'],
            'type' => $response['type'],
            'time' => $time,
            ResponseApi::APPOINTMENT => $appointment ,
        ]);
    }
    
    protected function takeReservation(array $request)
    {
        $issuer = $request['issuer'];
        $service = $request['service'];
        $contact = $request['contact'];
        $comments = $request['comments'];
        $humanresourceId = $request['humanresource'];
        $this->business = $request['business'];
        //return response()->json($request);
        
        //return response()->json($this->business->vacancies());
        
        $vacancies = $this->calendar()
                          ->forService($service->id)
                          ->withDuration($service->duration)
                          ->forDate($request['date_start'])
                          ->atTime($request['time_start'], $request['timezone'])
                          ->find();
        //return response()->json($vacancies);

        if ($vacancies->count() == 0) {
            // TODO: Log failure feedback message / raise exception
            //return false;
        }

        if ($vacancies->count() > 1) {
            // Log unexpected behavior message / raise exception
            $vacancy = $vacancies->first();
        }

        if ($vacancies->count() == 1) {
            $vacancy = $vacancies->first();
        }

        //$humanresourceId = $vacancy->humanresource ? $vacancy->humanresource->id : null;

        $startAt = $this->makeDateTimeUTC($request['date_start'], $request['time_start'], $request['timezone']);
        $finishAt = $this->makeDateTimeUTC($request['date_finish'], $request['time_finish'], $request['timezone']);//$startAt->copy()->addMinutes($service->duration);
        
        $appointment = $this->generateAppointment(
            $issuer,
            $this->business->id,
            $contact->id,
            $service->id,
            $startAt,
            $finishAt,
            $comments,
            $humanresourceId,
            $service->duration    
        );

        /* Should be moved inside generateAppointment() */
        if ($appointment->duplicates()) {
            $this->appointment = $appointment;

            throw new DuplicatedAppointmentException($appointment->code);
        }

        //$appointment->vacancy()->associate($vacancy);
        $appointment->save();

        return $appointment;
    }

    protected function generateAppointment(
        $issuerId,
        $businessId,
        $contactId,
        $serviceId,
        Carbon $startAt,
        Carbon $finishAt,
        $comments = null,
        $humanresourceId = null,
        $duration = null)
    {
        $appointment = new Appointment();

        $appointment->doReserve();
        $appointment->setStartAtAttribute($startAt);
        $appointment->setFinishAtAttribute($finishAt);
        $appointment->business()->associate($businessId);
        $appointment->issuer()->associate($issuerId);
        $appointment->contact()->associate($contactId);
        $appointment->service()->associate($serviceId);
        $appointment->humanresource()->associate($humanresourceId);
        $appointment->comments = $comments;
        $appointment->duration = $duration;
        $appointment->doHash();

        return $appointment;
    }
     protected function makeDateTime($date, $time, $timezone = null)
    {
        return Carbon::parse("{$date} {$time} {$timezone}");
    }

    protected function makeDateTimeUTC($date, $time, $timezone = null)
    {
        return $this->makeDateTime($date, $time, $timezone)->timezone('UTC');
    }
    
    protected function calendar()
    {
        if ($this->calendar === null) {
            $this->calendar = new Calendar($this->business->strategy, $this->business->vacancies(), $this->business->timezone);
        }

        return $this->calendar;
    }

    public function timetable()
    {
        if ($this->timetable === null) {
            $this->timetable = new TimetableStrategy($this->business->strategy);
        }

        return $this->timetable;
    }

    public function vacancies()
    {
        if ($this->vacancies === null && $this->business !== null) {
            $this->vacancies = new VacancyManager($this->business);
        }

        return $this->vacancies;
    }

    public function booking()
    {
        if ($this->booking === null && $this->business !== null) {
            $this->booking = new BookingManager($this->business);
        }

        return $this->booking;
    }


    /**
     * Determine if the Business has any published Vacancies available for booking.
     *
     * @param string $fromDate
     * @param int $days
     *
     * @return bool
     */
    public function isBookable($fromDate = 'now', $toDate)
    {
        $fromDate = Carbon::parse($fromDate)->timezone($this->business->timezone);
        $toDate = Carbon::parse($toDate)->timezone($this->business->timezone);
        
        logger()->debug(\GuzzleHttp\json_encode($fromDate));
        
        $count = $this->business
                      ->vacancies()
                      ->future($fromDate)
                      ->until($toDate)
                      ->count();
        
        logger()->debug(\GuzzleHttp\json_encode($count));
        return $count > 0;
    }
    
    /*
     * isNotColision between date in appointment
     */
    public function isCollision(Carbon $startAt, Carbon $finishAt, $hr, $appointment, $seconds = 60)
    {
        $startAt = Carbon::parse($startAt);//->timezone($this->business->timezone);
        logger()->debug(\GuzzleHttp\json_encode($startAt));

        $finishAt = Carbon::parse($finishAt);//->timezone($this->business->timezone);//$startAt->copy()->addMinutes($seconds);
        logger()->debug(\GuzzleHttp\json_encode($finishAt));

        $appointment = Appointment::query()
                //->whereRaw("(start_at BETWEEN '".$startAt."' AND  '".$finishAt."')")
                //->OrWhereRaw("(finish_at BETWEEN '".$startAt."' AND  '".$finishAt."')")
                ->where('status','<>',Appointment::STATUS_CANCELED)
                ->where('humanresource_id','=',$hr)
                ->whereNotIn('id',[$appointment])
                ->where(function($query) use ($startAt,$finishAt){
                    $query->whereBetween('start_at',[$startAt->addMinute(5),$finishAt->addMinute(-5)])
                    ->OrWhereBetween('finish_at',[$startAt->addMinute(5),$finishAt->addMinute(-5)]);
                })
                ->get()
                ->count()
                ;
        logger()->debug(\GuzzleHttp\json_encode($appointment));

        return $appointment;
    }
    /**
     * 
     * @param Request $request
     * @return type Description
     */
    public function ajaxGetContact(Request $request){

        /**
         * refactor!
         */
        //$contact_business = \Illuminate\Support\Facades\DB::select('select contact_id from business_contact where business_id='.$request->input('business_id'));
        $contact_business = \Illuminate\Support\Facades\DB::table('business_contact')
            ->select(['contact_id'])
            ->where('business_id','=',$request->input('business_id'))
            ->get()
            ->toArray();
        $business_client = [];
        $request_query = $request->input('query');
        $_where = [];
        if(preg_match("/\d{1,}/is",$request_query)){
            $_where = ['mobile','like',"%".$request_query."%"];
        } else {
            $_where = ['lastname','like',"%".$request_query."%"];
        };
        foreach($contact_business as $cb) array_push ($business_client, $cb->contact_id);
        $query = Contact::query(['firstname','lastname','mobile','id'])
                ->whereIn('id',$business_client)
                ->where($_where[0],$_where[1],$_where[2])
                ->limit(15)
                ->get()
                ->toArray();
        $response = [];
        foreach ($query as $row){
            $group = \App\Models\MedicalGroup::query(['name'])
                    ->where('contacts','LIKE','%'.$row['id'].'%')
                    ->get()
                    ->toArray();
            $group = (!empty($group)) ? $group[0]['name'] : '';
            array_push($response, [ 'name'=>$row['lastname'].' '.$row['firstname'].', '.$row['mobile'], 'id'=>$row['id'], 'group'=>$group ]);
        }
        return response()->json($response);
    }

    public function ajaxGetService(Request $request){

        $query = Service::query(['name','id'])->where('name','like',"%".$request->input('query')."%")->get()->toArray();
        $response = [];
        foreach ($query as $row){
            array_push($response, [ 'name'=>$row['name'], 'id'=>$row['id'] ]);
        }
        return response()->json($response);
    }
    
    public function ajaxgetCallendar(Request $request) {

        $business = Business::findOrFail($request->input('businessId',null));
        $this->business = $business;
        
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

        $issuer = auth()->user();
        
        $hr = $request->input('hr',0)==0 ? null : $request->input('hr');
        
        //$this->authorize('manage', $business);

        $start_at = $request->input('start_at',null);
        //$appointments = $this->concierge->business($business)->getActiveAppointments();
        //$appointments = $this->concierge->business($business)->getUnarchivedAppointments();
        $where_at = ($start_at!==null) ? \Carbon\Carbon::parse($start_at,$business->timezone)->addDays(-7) : \Carbon\Carbon::parse('last week',$business->timezone);
        $where_to = ($start_at!==null) ?  \Carbon\Carbon::parse($start_at,$business->timezone)->addDays(7) : \Carbon\Carbon::parse('next week',$business->timezone);
        
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
            ->get();        

        //logger()->debug($appointments);

        $jsAppointments = [];

        foreach ($appointments as $appointment) {
            $staff = Humanresource::find($appointment->humanresource_id);
            
            $leaf = MedicalHistory::getHistory($appointment->contact->id);
            $leaf = ($leaf->total()==0) ? 'leaf' : '';
            
            $sun = MedicalHistory::query()->where('appointment_id', '=',$appointment->id)->get()->count();
            $sun = ($sun==0) ? 'frown-o' : '';
            
            $file = MedicalFile::query()->where('contact_id', '=',$appointment->contact->id)->get()->count();
            $file = ($file==0) ? '' : 'file';

            /*
            $note = MedicalHistory::query()->where('appointment_id', '=',$appointment->id)->get()->toArray();
            if(count($note)>0){
                logger()->debug($note[0]['json_data']);
                $note = json_decode($note[0]['json_data']);
                if(isset($note->note)){
                    $note = ($note->note=='') ? '' : 'comment-o';
                } else {
                    $note = '';
                }
            }
            */

            $note = Notes::getNote($appointment->id);
            $notes = '';
            if($note) {
                $notes = null;
                $note->map(function($item) use (&$notes) {
                    $notes.= $item . "\n"; 
                });        
            };
            
            if( $hr!=null ){
                if($appointment->humanresource_id != $hr) continue;
                $jsAppointments[] = [
                    'id'    => $appointment->id,
                    'title' => $appointment->contact->lastname.' '.$appointment->contact->firstname.' '.$appointment->contact->mobile,//.' / '.$appointment->service->name.' / '.$staff->name,
                    'color' => $staff->color,
                    'start' => $appointment->start_at->timezone($business->timezone)->toIso8601String(),
                    'end'   => $appointment->finish_at->timezone($business->timezone)->toIso8601String(),
                    'service' => $appointment->service->name,
                    'staff' => $staff->name,
                    'icon'  => $leaf,  
                    'icon2' => $sun,
                    'icon3' => $file,
                    'icon4' => $note,
                    ];
            } else {
                
                $jsAppointments[] = [
                    'id'    => $appointment->id,
                    'title' => $appointment->contact->lastname.' '.$appointment->contact->firstname.' '.$appointment->contact->mobile,//.' / '.$appointment->service->name.' / '.$staff->name,
                    'color' => $staff->color,
                    'start' => $appointment->start_at->timezone($business->timezone)->toIso8601String(),
                    'end'   => $appointment->finish_at->timezone($business->timezone)->toIso8601String(),
                    'service' => $appointment->service->name,
                    'staff' => $staff->name,
                    'icon'  => $leaf,  
                    'icon2' => $sun,
                    'icon3' => $file,
                    'icon4' => $note,
                    ];
            }
        }
        
        //days free - holidays
        $holiDays = $this->freeDays();
        foreach($holiDays as $hd) {
            $jsAppointments[] = $hd;
        }
        
        $asysta = cookie('asysta')->getValue();
        
        unset($appointments);
        return response()->json($jsAppointments);
    }
    
    public static function freeDays() {
        $fdRows = [];
        $fdOut = [];
        $fdRows = file(resource_path().'/files/holidays.csv');
        foreach ($fdRows as $row) {
            $comma = explode(";", $row);
            $date = explode("-", $comma[0]);
            $year = $date[2];
            $month = $date[1];
            $day = $date[0];
            $start_at = Carbon::create($year, $month, $day)->toIso8601String();
            $fdOut[] = [
                'id'    => -1,
                'title' => $comma[2],
                'color' => "#cc0000",
                'start' => $start_at,
                'allDay' => TRUE,
            ];
        }
        return $fdOut;
    }
}
