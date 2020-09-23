<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use \Carbon\Carbon;
use App\Http\Requests\Statistics\GetRequest;
use App\Http\Resources\Statistics\DefaultResources;
use App\Models\Datasets;
use App\Models\MedicalHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Translation\Loader\CsvFileLoader;
use Timegridio\Concierge\Models\Contact;

class ContactsController extends Controller
{

    public function importFromFile(GetRequest $request, Business $business) : JsonResponse
    {
        $business = $business->first();
        $response = ['status'=>'ok','data'=>'','error'=>''];
        $uploadedFile = $request->file()[0];
        $filename = $uploadedFile->getClientOriginalName();
        $file = Storage::disk('local')->putFile('temp/', $uploadedFile);
        $contacts = explode("\n", Storage::get($file)) ;
        $response['data'] = 'Ilość rekordów: ' . count($contacts);
        if (count($contacts) > plan('limits.contacts', $business->plan)) {
            $response['error'] = trans('app.saas.plan_limit_reached');
            $response['status'] = 'error';
        };
        foreach($contacts as $index => $contact) {
            if($business->addressbook()->count() > plan('limits.contacts', $business->plan))
                break;
            $register = [
                'firstname' => $contact['firstname'],
                'lastname' => $contact['lastname'],
                'email' => $contact['email'],
                'nin' => $contact['nin'],
                'gender' => $contact['gender'],
                'birthdate' => $contact['birthdate'],
                'mobile' => $contact['mobile'],
                'mobile_country' => $contact['mobile_country']
            ];
            
            $business->addressbook()->register($register);
        };
        
        Storage::disk('local')->delete($file);

        return response()->json($response);
    }
}
