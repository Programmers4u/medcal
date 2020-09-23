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
        $filename = $uploadedFile->getClientOriginalName();
        $file = Storage::disk('local')->putFile('temp/', $uploadedFile);
        // $files = Storage::get($file);

        $row = 1;
        if (($handle = fopen($file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
            fclose($handle);
        }        
        
            //foreach($request->file()[0] as $file){
            // $path = Storage::disk('local')->putFile('medical/'.$business->id.'/import_contacts', $file);
            // $originalName = $file->getClientOriginalName();
            // $response['data'] = $path;
        //}
        //$path = Storage::disk('local')->putFile('medical', $request->file()[0]);
        //$result = MedicalFile::putFile($path, $request->input('contact_id'), $request->input('description'), $request->input('history_id'), $request->input('type'));

        return response()->json($response);
    }
}
