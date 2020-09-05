<?php

namespace App\Http\Controllers\API;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use \Carbon\Carbon;
use App\Http\Requests\Statistics\GetRequest;
use App\Http\Resources\Statistics\DefaultResources;
use App\Models\MedicalHistory;
use Illuminate\Http\JsonResponse;

class DatasetsController extends Controller
{

    public function create(GetRequest $requestst, Business $business) : JsonResponse
    {
        // $DefaultResources = new DefaultResources($model2);
        return response()->json([
        ]);
    }

}
