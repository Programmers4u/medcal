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

class StatisticsController extends Controller
{

    public function getIndex(GetRequest $requestst, Business $business) : JsonResponse
    {
        $model = MedicalHistory::query()
            ->get()
            ->toArray()
        ;
        foreach($model as $m) {
            $edm = json_decode($m['json_data']);
            Datasets::create([
                Datasets::DATE_OF_EXAMINATION  => Carbon::parse(),
                Datasets::BIRTHDAY => Carbon::parse(),
                Datasets::SEX => Datasets::SEX_FEMALE,
                Datasets::DIAGNOSIS => $edm->diagnosis,
                Datasets::PROCEDURES => $edm->procedures,        
            ]);    
            // dd( $m );
        }
        
        $dataset = Datasets::query();
        dd($dataset->get()->toArray());

        // $DefaultResources = new DefaultResources($model2);
        // return response()->json([
        //     ResponseApi::STATISTICS => $DefaultResources->toArray,
        // ]);
    }

    public function countSame($tab) {
        $test = [];
        $counter = [];
        foreach($tab as $item) {
            if(!in_array($item,$test)) {
                $n = array_push($test,$item);
                $counter[$item] = 1;
            } else {
                $counter[$item] += 1;
            }
        }
        return $counter;
    }

}
