<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use App\Http\Requests\Contacts\PutRequest;
use App\Http\Resources\DefaultResources;
use App\Jobs\ProcessContactImport;
use Illuminate\Http\JsonResponse;

class ContactsController extends Controller
{
    public function importFromFile(PutRequest $request) : JsonResponse
    {
        $this->validate($request, $request->rules());

        $business = Business::findOrFail($request->input('businessId'));
        $user = auth()->user();

        $response = ['status'=>'ok','data'=>0,'error'=>''];

        $uploadedFile = $request->file()[0];

        $path = env('STORAGE_PATH','').DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        checkDir($path);

        $originalName = $uploadedFile->getClientOriginalName();
        $ext = $uploadedFile->clientExtension();
        $fileName = md5($originalName).'.'.$ext;
        $tmpFile = $uploadedFile->getPathName();

        $command = "cp ".$tmpFile.' '.base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName;
        system($command);

        $count = count( file(base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName) );
        $response['data'] = 'Kontakty są importowane (' . $count . ')';
        $limit = plan('limits.contacts', $business->plan);
        dispatch(new ProcessContactImport($business, $user, $limit, base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName));

        return response()->json(
            $response
        );
    }
}
