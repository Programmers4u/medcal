<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalTemplate\DefaultRequest;
use App\Http\Requests\MedicalTemplate\DeleteRequest;
use App\Http\Requests\MedicalTemplate\ImportRequest;
use Timegridio\Concierge\Models\Business;
use App\Jobs\ProcessDatasetsImport;
use App\Jobs\ProcessMedicalTemplateImport;
use App\Models\MedicalTemplates;
use Illuminate\Http\JsonResponse;

class MedicalTemplateController extends Controller
{

    public function import(ImportRequest $request, Business $business) : JsonResponse
    {
        $this->validate($request, $request->rules());

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

        $datasets = file(base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName);
        $response['data'] = __('medicaltemplate.alert.import') . count($datasets);

        dispatch(new ProcessMedicalTemplateImport($business, base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName));

        return response()->json($response);
    }

    public function delete(DeleteRequest $request) : JsonResponse
    {
        $this->validate($request, $request->rules());

        $response = ['status'=>'ok','data'=>'','error'=>''];

        $response['data'] = MedicalTemplates::where(MedicalTemplates::ID, $request->id)->delete();

        return response()->json($response);
    }
}
