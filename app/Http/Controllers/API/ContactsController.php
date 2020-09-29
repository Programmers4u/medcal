<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use App\Http\Requests\Contacts\PutRequest;
use App\Jobs\ProcessContactImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Translation\Loader\CsvFileLoader;
use Timegridio\Concierge\Models\Contact;

class ContactsController extends Controller
{
    public function importFromFile(PutRequest $request, Business $business) : JsonResponse
    {
        $response = ['status'=>'ok','data'=>'','error'=>''];
        $uploadedFile = $request->file()[0];
        $file = Storage::disk('local')->putFile('temp', $uploadedFile);
        $contacts = explode("\n" ,Storage::get($file));
        $response['data'] = 'Ilość rekordów: ' . count($contacts);
        if (count($contacts) > plan('limits.contacts', $business->plan)) {
            $response['error'] = trans('app.saas.plan_limit_reached');
            $response['status'] = 'error';
        } else {
            dispatch(new ProcessContactImport($business, $file));
        }
        return response()->json($response);
    }
}
