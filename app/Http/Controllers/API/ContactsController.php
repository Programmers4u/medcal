<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use App\Http\Requests\Contacts\PutRequest;
use App\Jobs\ProcessContactImport;
use Illuminate\Http\File;
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

        $path = env('STORAGE_PATH','').DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        checkDir($path);

        $originalName = $uploadedFile->getClientOriginalName();
        $ext = $uploadedFile->clientExtension();
        $fileName = md5($originalName).'.'.$ext;
        $tmpFile = $uploadedFile->getPathName();

        $command = "cp ".$tmpFile.' '.base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName;
        system($command);

        $contacts = file(base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName);
        $response['data'] = 'Ilość rekordów: ' . count($contacts);
        // if (count($contacts) > plan('limits.contacts', $business->plan)) {
        //     $response['error'] = trans('app.saas.plan_limit_reached');
        //     $response['status'] = 'error';
        // } else {
            dispatch(new ProcessContactImport($business, base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName));
        // }
        return response()->json($response);
    }
}
