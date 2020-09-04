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

class StatisticsController extends Controller
{

    public function getIndex(GetRequest $requestst, Business $business) : JsonResponse
    {
        $model = MedicalHistory::query()
            ->get()
            ->toArray()
        ;
        $procedures = [];
        $diagnosis = [];
        $time = [];
        foreach($model as $m) {
            $edm = json_decode($m['json_data']);
            array_push($procedures, $edm->procedures);

            array_push($diagnosis, $edm->diagnosis);
            array_push($time, $m['created_at']);
            // dd( $m );
        }
        dd($procedures, $diagnosis);
        // dd($model1->get()->toArray());
        $data = [
            'procedures' => $procedures,
            'diagnosis' => $diagnosis,
        ];

        // dd($data);
        // dd($time);
        $return = [
            'labels' => $time,
            'label' => 'procedures',
            'data' => [15,2,count($data['procedures']),count($data['diagnosis'])],
        ];
        // dd($return);
        return response()->json([
            ResponseApi::STATISTICS => $return,
        ]);

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
