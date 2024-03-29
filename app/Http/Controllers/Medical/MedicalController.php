<?php

namespace App\Http\Controllers\Medical;

use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use Timegridio\Concierge\Concierge;
use Timegridio\Concierge\Models\Business;
use Timegridio\Concierge\Models\Contact;
use Illuminate\Support\Facades\Storage;
use App\Models\MedicalFile;
use App\Http\Controllers\Controller;
use App\Http\Consts\ResponseApi;
use App\Http\Requests\Appointments\GetNoteRequest;
use App\Http\Requests\AppointmentNoteRequest;
use App\Http\Requests\Appointments\PutNoteRequest;
use App\Http\Resources\Medicines\DefaultResources;
use App\Jobs\ProcessMedicalHistoryPdf;
use App\Models\MedicalMedicines;
use App\Models\Notes;
use Illuminate\Http\JsonResponse;
use Timegridio\Concierge\Models\Appointment;
use App\Models\MedicalTemplates;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;
use Timegridio\Concierge\Models\Humanresource;

class MedicalController extends Controller
{
    //
    protected $concierge;
    
    public function __construct(Concierge $concierge) {
        $this->concierge = $concierge;
        parent::__construct();
    }

    public function index(Business $business, Contact $contact) {
        
        $this->authorize('manage', $business);
        
        $contacts = $business->addressbook()->find($contact);

        if( null === $contacts ) {
            flash()->warning('Brak kontaktów');
             return redirect()->back();
        }

        $appointments = $contacts->appointments();
        $appointments = $appointments
                ->whereNotIn('id',function($query){
                  $query->select('appointment_id')->from('medical_history');  
                })
                ->orderBy('start_at','asc')->ofBusiness($business->id)->Active()->get();

        $interviewData = $this->getInterview($contact); 

        $permission = $this->getPermission($contact);

        $historyPagin = Cache::remember(md5($contact->id), env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use ($contact) {
           return $this->getHistory($contact); 
        });

        $files = $this->getFiles($business, $contact);
        
        $group = []; //MedicalGroup::getAll($business);
        
        $template = MedicalTemplates::getAll($business);
        
        $permission_template = $this->getPermissionFile($business);
        
        $typeHistory = MedicalFile::$typeHistory;
        $typePermission = MedicalFile::$typePermission;
        $typePermissionTemplate = MedicalFile::$typePermissionTemplate;
       
        $typeTemplateA = MedicalTemplates::TYPE_ANSWER;
        $typeTemplateQ = MedicalTemplates::TYPE_QUESTION;
       
        $staffs = $business->humanresources;
        $appoStaff = Appointment::query()
               ->where('business_id','=',$business->id)
               ->where('start_at','>', \Carbon\Carbon::today()->timezone($business->timezone)) 
               ->where('start_at','<', \Carbon\Carbon::tomorrow()->timezone($business->timezone)) 
               ->whereIn('status',['C','R'])
               ->orderBy('start_at','ASC')
               ->get();

        $cookie = cookie('medcallaststaff')->getValue();

        $agenda = [];
        foreach($appoStaff as $ag){
            $staff = Humanresource::query()
                    ->where('id','=',$ag->humanresource_id)
                    ->where('business_id','=',$business->id)
                    ->get();
            $staff->name = (empty($staff[0]->name)) ? '' : $staff[0]->name;
            $userApp = Contact::query()->where('id','=',$ag->contact_id)->get();
            $contactName = $userApp[0]->firstname.' '.$userApp[0]->lastname;
            $rec = [
                'id'=>$ag->id,
                'start_at'=>\Carbon\Carbon::parse($ag->start_at)->timezone($business->timezone),
                'staff'=>$staff->name,
                'staff_id'=>$ag->humanresource_id,
                'contact_name' => $contactName,
            ];
            array_push($agenda, $rec);
        };
        return view('medical._modal_documents',compact(
            'agenda',
            'staffs',
            'typeTemplateQ',
            'typeTemplateA',
            'typeHistory',
            'typePermission',
            'typePermissionTemplate',
            'permission_template',
            'template',
            'group',
            'files',
            'historyPagin',
            'permission',
            'interviewData',
            'appointments',
            'contacts',
            'business'
        ));
    }
    
    /**
     * 
     * Obsługa Grupy powinna być w oddzielnym Kontrolerze
     */
        
    public function putGroup(Request $request){
        $response = ['status'=>'ok','error'=>''];
        // $result = MedicalGroup::putGroup($request->input('name'),$request->input('id'));
        // $response['error'] = $result;
        return response()->json($response);
    }

    public function groupCreate(Business $business){
        return view('medical.groups.create', compact('business'));
    }

    public function groupEdit(Business $business, $group_id){
        $name = MedicalGroup::query()
                ->select(['name'])
                ->where('id','=',$group_id)
                ->get()
        ;
        return view('medical.groups.edit', compact('business','group_id','name'));
    }

    public function deleteGroup(Business $business, Request $request){
        $result = \App\Models\MedicalGroup::destroy($request->input('id'));
        return $result;
    }

    public function updateGroup(Business $business, Request $request){
        $result = \App\Models\MedicalGroup::destroy($request->input('group_id'));
        return $this->groupIndex($business);
    }

    public function groupIndex(Business $business){
        $groups = []; //\App\Models\MedicalGroup::all(['id','name']);
        return view('medical.groups.index',compact('business','groups'));
    }
    
    public function addToGroup(Request $request){
        $result = '';
        $gr = \App\Models\MedicalGroup::find($request->input('group_id'));
        $contacts = explode(",", trim($gr->contacts,","));
        if(!in_array($request->input('contact_id'), $contacts)) {
            array_push($contacts,$request->input('contact_id'));
            $gr->contacts = trim(implode(",", $contacts),",");
            $result = $gr->save();
        }
        return response()->json(['status'=>$result]);
    }
    
    public function delFromGroup(Request $request){
        $gr = \App\Models\MedicalGroup::find($request->input('group_id'));
        $contacts = explode(",", $gr->contacts);
        $_contacts = [];
        foreach($contacts as $contact){
            if($contact!=$request->input('contact_id'))
                array_push($_contacts,$contact);
        }

        $gr->contacts = implode(",", $_contacts);
        $result = $gr->save();

        return response()->json(['status'=>$result]);
    }
    
    public function getPermissionFile(Business $business){
        $_files = MedicalFile::getFile(0);
        $files = [];
        //$contents = Storage::disk('local')->allFiles('medical\\'.$business->id.'\permission_template');
        //dd($contents);
        foreach($_files as $file)
            array_push ($files, [
                'id'=>$file['id'],
                'url'=>Storage::url($file['file']),
                'description'=>$file['description'],
                'type'=>$file['type'],
                'medical_history_id'=>$file['medical_history_id'],
                'original_name' =>$file['$original_name'],                
                    ]);
        //dd($contents);
        //$visibility = Storage::getVisibility($contents[0]);
        //dd($visibility);
//        $file = env('APP_URL').'/'.str_replace("storage/","",env('STORAGE_PATH')).Storage::disk('local')->url($contents[0]);
        
        return $files;
        
//        return $files = Storage::disk('local')->allFiles('medical\\'.$business->id.'\permission_template');
        //dd($files);
    }
    
    public function putPermissionFile(Business $business,Request $request){
        $response = ['status'=>'ok','data'=>'','error'=>''];
        //dd($request->file()[0]);
        $file = $request->file()[0];
        //foreach($request->file()[0] as $file){
            $path = Storage::disk('local')->putFile('medical/'.$business->id.'/permission_template', $file);
            $originalName = $file->getClientOriginalName();
            $description = (empty($request->input('description'))) ? $originalName : preg_replace("/\r\n/is"," ",$request->input('description'));
            $result = MedicalFile::putFile($originalName, $path, 0, $description, $request->input('history_id'), $request->input('type'));
            $response['data'] = $result;
        //}
        //$path = Storage::disk('local')->putFile('medical', $request->file()[0]);
        //$result = MedicalFile::putFile($path, $request->input('contact_id'), $request->input('description'), $request->input('history_id'), $request->input('type'));
        return $response;
        
    }

    public function deletePermissionFile(){
        
    }
    

    public function deleteFile(Business $business, Request $request){
        //$path = Storage::disk('local')->putFile('medical\\'.$business->id, $request->file()[0]);
        $result = MedicalFile::deleteFile($request->input('id'));
        return $result;
    }

    private function generatePathToFile(Business $business, Contact $contact) {
        return '/app/business/'.$business->id.'/medical/'.$contact->id;
    }
    /**
     * putFile function
     *
     * @param Business $business
     * @param Request $request
     * @return array
     */
    public function putFile(Business $business, Request $request){
        $response = ['status'=>'ok','data'=>''];

        $contact = Contact::find($request->input('contact_id', 0));
        $path = env('STORAGE_PATH','').DIRECTORY_SEPARATOR.$this->generatePathToFile($business, $contact);
        checkDir($path);

        $file = $request->file()[0];
        //foreach($request->file() as $file){

        $originalName = $file->getClientOriginalName();
        $ext = $file->clientExtension();
        $fileName = md5($originalName).'.'.$ext;
        $tmpFile = $file->getPathName();

        $command = "cp ".$tmpFile.' '.base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName;
        system($command);

        $description = (empty($request->input('description'))) ? $originalName : $request->input('description');
        $result = MedicalFile::putFile($originalName, $fileName, $request->input('contact_id'), $description, $request->input('history_id'), $request->input('type'));
        $response['data'] = $result;
        //}
        return $response;
    }

    /**
     * getFile function
     *
     * @param Business $business
     * @param Contact $contact
     * @return array 
     */
    public function getFiles(Business $business, Contact $contact){
        $_files = MedicalFile::getFile($contact->id);
        $files = [];
        $storage = $this->generatePathToFile($business, $contact);
        $public = 'public/'.env('STORAGE_PATH','').$storage;
        foreach($_files as $file) {
            checkDir($public, 0755);

            $command = "cp ".storage_path('').$storage.DIRECTORY_SEPARATOR.$file['file'].' '.base_path('').DIRECTORY_SEPARATOR.$public.DIRECTORY_SEPARATOR.$file['original_name'];
            system($command);

            array_push ($files, [
                'id'=>$file['id'],
                'url'=> url('/').'/'.env('STORAGE_PATH','').$storage.'/'.$file['original_name'],
                'description'=>$file['description'],
                'type'=>$file['type'],
                'medical_history_id'=>$file['medical_history_id'],
                'original_name' =>$file['original_name'],
                ]
            );
        };
        return $files;
    }

    public function getInterview(Contact $contact){
        $interview = new \App\Models\MedInterview();
        $interviewData = $interview->getJsonData($contact->id);
        return $interviewData;
    }

    public function getPermission(Contact $contact){
        $permission = new \App\Models\MedPermission();
        $permissionData = $permission->getJsonData($contact->id);
        return $permissionData;
    }

    public function getHistory(Contact $contact) {
        $historyData = MedicalHistory::getHistory($contact->id);
        return $historyData;
    }

    public function exportHistory($business, $contact) : JsonResponse
    {
        $business = Business::where('slug', $business)->first();
        $contact = Contact::find($contact);
        dispatch(new ProcessMedicalHistoryPdf($business, $contact));
        return response()->json([
            'status' => 'ok',
        ]);
    }

    public function putHistory(Request $request){
        
        $contact_id = $request->input('contact_id');
        $business_id = $request->input('business_id');
        $appointment_id = $request->input('appointment_id');
        $history_id = $request->input('history_id');
        $staff = $request->input('staff');
        $json_data = $request->input('json_data');
        $type = $request->input('type');
        if($history_id == -1 || $history_id == 0) {
            $description = 'Wpis został dodany';
            $result = MedicalHistory::putHistory($json_data, $contact_id, $appointment_id, $staff, $business_id);
            try{
                $appointment = \Timegridio\Concierge\Models\Appointment::findOrFail($appointment_id);
                // logger()->debug($appointment);
                $appointment->{'status'} =  Appointment::STATUS_SERVED;
                $appointment->save();
                // $business = Business::findOrFail($business_id);
                // if($appointment && $business){
                //     $this->concierge->business($business);
                //     $appointmentManager = $this->concierge->booking()->appointment($appointment->hash);
                //     // $appointment = $appointmentManager->confirm();
                //     $appointment = $appointmentManager->serve();
                // }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                logger()->debug($e->getMessage());
            }

        } else {
            $description = 'Wpis został zaktualizowany';
            $result = MedicalHistory::updateHistory($json_data, $contact_id, $history_id, $staff, $business_id);        
        }
        $result = ($result) ? TRUE : FALSE; 
        $result = ($result) ? $description : 'Nastąpił wyjątek, proszę spróbuj za chwilę.'; 
        return response()->json($result);
    }

    public function putInterview(Request $request){
        $response = ['transmission'=>'ok'];
        
        $interview = new \App\Models\MedInterview();
        $interviewData = $interview->getJsonData($request->input('contact_id'));
        
        $options = [
            'contact_id' => $request->input('contact_id'),
            'action' => $request->input('action'),
            'pair' => $request->input('pair'),
        ];

        $result = $interview->updateJsonModel($options);
        if(!$result->id) $response['transmission'] = 'no';
        return response()->json($response);
    }

    public function putPermission(Request $request){
        $response = ['transmission'=>'ok'];
        
        $permission = new \App\Models\MedPermission();
        
        $permissionData = $permission->getJsonData($request->input('contact_id'));
        $options = [
            'contact_id' => $request->input('contact_id'),
            'business_id' => $request->input('business_id'),
            'pair' => $request->input('pair'),
        ];

        $result = $permission->updateJsonModel($options);
        //if(!$result->id) $response['transmission'] = 'no';
        return response()->json($response);
    }
    
    public function ajaxAddNoteMedHistory(Request $request){
        $response = ['status'=>'false'];
        
        $business = Business::findOrFail($request->input('business_id'));
        
        $issuer = auth()->user();
        
        //$this->authorize('manage', $business);

        $historyId = $request->input('history_id',NULL);
        if($historyId!=NULL) {
            $history = \App\Models\MedicalHistory::query()->where('id', '=',$historyId);
            $json_data = $history->get()[0]->toArray();
            $json_data=json_decode($json_data['json_data']);
            $note = (isset($json_data->note)) ? $json_data->note : '';
            $json_data->note = $request->input('note','')."\n--\n".$note;
            $history->update(['json_data'=> json_encode($json_data)]);
            $response['result']=$history->get()->toArray();        
        }
        $response['status']='ok';
        return response()->json($response);
    }
    
    public function ajaxGetNote(GetNoteRequest $request) : JsonResponse {

        $this->validate($request, $request->rules());

        $appointmentId = $request->input('appointmentId',null);
        $businessId = $request->input('businessId',null);
        $contactId = $request->input('contactId',null);

        $notes = Notes::getNote($appointmentId, $businessId, $contactId);

        $response = [
            ResponseApi::MEDICAL_NOTE => [
                'note' => $notes,
                'status' => 'ok',    
            ]
        ];
        return response()->json($response);
    }

    public function ajaxPutNote(PutNoteRequest $request) : JsonResponse 
    {
        $this->validate($request, $request->rules());

        $app_id = $request->input('appointmentId',null);
        $note = $request->input('note',null);
        $businessId = $request->input('businessId',null);
        $contactId = $request->input('contactId',null);
        $notes = Notes::setNote($note, $app_id, $businessId, $contactId);
        $response = [
            ResponseApi::MEDICAL_NOTE => [
                'note' => $notes ? $notes->note : null,
                'status' => 'ok',    
            ]
        ];
        return response()->json($response);
    }

    public function indexLink(Business $business, \Timegridio\Concierge\Models\Appointment $link){
        //dd($link);
        $app = \Timegridio\Concierge\Models\Appointment::query()->find($link->id);
        $contact = Contact::query()->find($app->contact_id) ;
        return $this->index($business, $contact);
    }

    public function ajaxGetMedicines(Request $request) : JsonResponse 
    {
        $medicine = $request->input('medicine');

        $medicines = MedicalMedicines::query()
            ->where(MedicalMedicines::NAME, 'like', '%' . $medicine . '%')
            ->limit(10)
            ->get()
            ;
        
        return response()->json(
            new DefaultResources($medicines)
        );
    }
}
