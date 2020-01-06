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
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class MedicalController extends Controller
{
    //
    protected $concierge;
    
    public function __construct(Concierge $concierge) {
        $this->concierge = $concierge;
        parent::__construct();
    }


    public function index(Business $business, Contact $contact){
        
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s contactId:%s', $business->id, $contact->id));

        $this->authorize('manage', $business);
        
        // BEGIN //
        $contacts = $business->addressbook()->find($contact);
        //dd($contacts);
        if( null == $contacts ) {
            flash()->warning('Brak kontaktów');
             return redirect()->back();
        }

        $appointments = $contacts->appointments();
        $appointments = $appointments
                ->whereNOTIn('id',function($query){
                  $query->select('appointment_id')->from('medical_history');  
                })
                ->orderBy('start_at','asc')->ofBusiness($business->id)->Active()->get();


        $interviewData = $this->getInterview($contact); 

        $permission = $this->getPermission($contact);

        $historyPagin = $this->getHistory($contact);

        $files = $this->getFiles($business, $contact);
        
        $group = \App\Models\MedicalGroup::all();
        
        $template = \App\Models\MedicalTemplate::all();
        
        $permission_template = $this->getPermissionFile($business);
        
        $typeHistory = MedicalFile::$typeHistory;
        $typePermission = MedicalFile::$typePermission;
        $typePermissionTemplate = MedicalFile::$typePermissionTemplate;
       
        $typeTemplateA = \App\Models\MedicalTemplate::$typeA;
        $typeTemplateQ = \App\Models\MedicalTemplate::$typeQ;
       
        $staffs = $business->humanresources;
        $appoStaff = \Timegridio\Concierge\Models\Appointment::query()
               ->where('business_id','=',$business->id)
               //->where('humanresources_id','=',1)
               ->where('start_at','>', \Carbon\Carbon::today()->timezone($business->timezone)) 
               ->where('start_at','<', \Carbon\Carbon::tomorrow()->timezone($business->timezone)) 
               ->whereIn('status',['C','R'])
               ->orderBy('start_at','ASC')
               ->get();
       //dd($appoStaff);
        /*$status = '';
        switch ($status){
            case 'active' : 
                $agenda = $this->concierge->business($business)->getActiveAppointments();
            break;
            case 'unserved' : 
                $agenda = $this->concierge->business($business)->getUnservedAppointments();
            break;
            default:
                $agenda = $this->concierge->business($business)->getUnarchivedAppointments();
        }*/
        $cookie = cookie('medcallaststaff')->getValue();
        //dd($cookie);
        $agenda = [];
        foreach($appoStaff as $ag){
            $staff = \Timegridio\Concierge\Models\Humanresource::query()
                    ->where('id','=',$ag->humanresource_id)
                    ->where('business_id','=',$business->id)
                    ->get();
            //dd($staff);
            $staff->name = (empty($staff[0]->name)) ? '' : $staff[0]->name;
            $userApp = Contact::query()->where('id','=',$ag->contact_id)->get();
            //dd($userApp);
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
        //dd($historyPagin);
        //$agenda = $agenda[2]->id;
        //dd($agenda->links());
        //dd($appointments);
        return view('medical._modal_documents',compact('agenda','staffs','typeTemplateQ','typeTemplateA','typeHistory','typePermission','typePermissionTemplate','permission_template','template','group','files','historyPagin','permission','interviewData','appointments','contacts','business'));
    }
    
    /**
     * 
     * Obsługa Grupy powinna być w oddzielnym Kontrolerze
     */
        
    public function putGroup(Request $request){
        $response = ['status'=>'ok','error'=>''];
        $result = \App\Models\MedicalGroup::putGroup($request->input('name'),$request->input('id'));
        $response['error'] = $result;
        return response()->json($response);
    }

    public function groupCreate(Business $business){
        return view('medical.groups.create', compact('business'));
    }

    public function groupEdit(Business $business, $group_id){
        $name = \App\Models\MedicalGroup::query()
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
        $groups = \App\Models\MedicalGroup::all(['id','name']);
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

    public function getHistory(Contact $contact){
        //$history = new MedicalHistory();
        $historyData = MedicalHistory::getHistory($contact->id);
        return $historyData;
    }

    public function exportHistory($bussiness,$contact){
        //$history = new MedicalHistory();
        $historyData = MedicalHistory::query()
                ->select('medical_history.updated_at','medical_history.created_at','json_data','contacts.nin','contacts.gender','contacts.firstname','contacts.lastname','contacts.birthdate','humanresources.name')
                ->leftJoin('contacts','contacts.id','=','medical_history.contact_id')
                ->leftJoin('humanresources','humanresources.id','=','humanresources_id')
                ->where('medical_history.contact_id','=',$contact)
                ->get()->toArray();
        //getHistory($contact);
        //dd($historyData);
        $bus = Business::where('slug','=',$bussiness)->get()->toArray();
        //dd($bus);
        //dd($contact);

        $_files = MedicalFile::getFile($contact);
        $files = [];
        foreach($_files as $file)
            array_push ($files, [
                'id'=>$file['id'],
                'url'=>Storage::url($file['file']),
                'description'=>$file['description'],
                'type'=>$file['type'],
                'medical_history_id'=>$file['medical_history_id'],
                'original_name' =>$file['$original_name'],
                    ]);
        $photos = $_files->items();
        $pdf = Pdf::loadView('medical.pdf.export', compact('historyData','bus','photos'));
        $fileName = (is_array($historyData)) ? $historyData[0]['lastname'].'_'.$historyData[0]['firstname'].'_history_document.pdf' : 'history_document.pdf';
	return $pdf->download($fileName);
        
    }

    public function putHistory(Request $request){
        logger()->info(__METHOD__);
        
        $contact_id = $request->input('contact_id');
        $business_id = $request->input('business_id');
        $appointment_id = $request->input('appointment_id');
        $history_id = $request->input('history_id');
        $staff = $request->input('staff');
        $json_data = $request->input('json_data');
        $type = $request->input('type');
        if($history_id == -1 || $history_id == 0) {
            $description = 'Wpis został dodany';
            $result = MedicalHistory::putHistory($json_data, $contact_id, $appointment_id, $staff);
            try{
                $appointment = \Timegridio\Concierge\Models\Appointment::findOrFail($appointment_id);
                logger()->debug($appointment);

                $business = Business::findOrFail($business_id);
                if($appointment && $business){
                    $this->concierge->business($business);
                    $appointmentManager = $this->concierge->booking()->appointment($appointment->hash);
                    //$appointment = $appointmentManager->confirm();
                    $appointment = $appointmentManager->serve();
                }
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
                logger()->debug($e->getMessage());
            }

        } else {
            $description = 'Wpis został zaktualizowany';
            $result = MedicalHistory::updateHistory($json_data, $contact_id, $history_id, $staff);        
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
        
        logger()->info(__METHOD__);
        logger()->info(sprintf('businessId:%s', $business->id));

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
    

    public function indexLink(Business $business, \Timegridio\Concierge\Models\Appointment $link){
        //dd($link);
        $app = \Timegridio\Concierge\Models\Appointment::query()->find($link->id);
        $contact = Contact::query()->find($app->contact_id) ;
        return $this->index($business, $contact);
    }
}
