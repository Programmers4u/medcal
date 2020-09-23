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
        $response = ['status'=>'ok','data'=>'','error'=>''];

        $uploadedFile = $request->file()[0];
        // $filename = $uploadedFile->getClientOriginalName();
        $file = Storage::disk('local')->putFile('temp', $uploadedFile);
        // dd($file);
        $contacts = explode("\n" ,Storage::get($file));
        $response['data'] = 'Ilość rekordów: ' . count($contacts);
        // if (count($contacts) > plan('limits.contacts', $business->plan)) {
        //     $response['error'] = trans('app.saas.plan_limit_reached');
        //     $response['status'] = 'error';
        // };

        // dd($contacts);
    foreach($contacts as $index => $contact) {
        // dd($contact);
        if($index > 200) break;
            // if($business->contacts()->count() > plan('limits.contacts', $business->plan))
                // break;
            $register = [
                'firstname' => $contact[1],
                'lastname' => $contact[2],
                'nin' => $contact[3],
                'gender' => $contact[4],
                'birthdate' => Carbon::parse($contact[5]),
                'mobile' => $contact[6],
                'email' => $contact[7],
                // 'mobile_country' => $contact['mobile_country']
            ];
            
            $business->addressbook()->register($register);
        };
        
        Storage::disk('local')->delete($file);

        return response()->json($response);
    }
}
