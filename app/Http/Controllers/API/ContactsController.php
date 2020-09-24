<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use \Carbon\Carbon;
use App\Http\Requests\Statistics\GetRequest;
use App\Http\Resources\Statistics\DefaultResources;
use App\Jobs\ProcessContactImport;
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
        $file = Storage::disk('local')->putFile('temp', $uploadedFile);
        $contacts = explode("\n" ,Storage::get($file));
        $response['data'] = 'Ilość rekordów: ' . count($contacts);
        dispatch(new ProcessContactImport($file, $business));
        return response()->json($response);
    }
}
