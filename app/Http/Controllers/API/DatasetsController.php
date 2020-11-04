<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Datasets\CreateRequest;
use App\Http\Requests\Datasets\ImportRequest;
use Timegridio\Concierge\Models\Business;
use \Carbon\Carbon;
use App\Http\Requests\Statistics\GetRequest;
use App\Http\Resources\Statistics\DefaultResources;
use App\Jobs\ProcessDatasetsImport;
use App\Models\MedicalHistory;
use Illuminate\Http\JsonResponse;

class DatasetsController extends Controller
{

    public function create(CreateRequest $request, Business $business) : JsonResponse
    {
        // $DefaultResources = new DefaultResources($model2);
        return response()->json([
        ]);
    }

    public function import(ImportRequest $request, Business $business) : JsonResponse
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

        $datasets = file(base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName);
        $response['data'] = 'Ilość rekordów: ' . count($datasets);

        dispatch(new ProcessDatasetsImport($business, base_path().DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$fileName));

        return response()->json($response);
    }
}
