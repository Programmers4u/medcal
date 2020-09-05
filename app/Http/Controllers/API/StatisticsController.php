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
                Datasets::SEX => Datasets::SEX_MALE,
                Datasets::DIAGNOSIS => $edm->diagnosis,
                Datasets::PROCEDURES => $edm->procedures,        
            ]);    
        }
        
        $dataset = Datasets::query()
            ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
            ->groupBy(Datasets::DIAGNOSIS)
            ->get()->toArray()
            ;

        $datasetFemale = Datasets::query()
            ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
            ->where(Datasets::SEX, Datasets::SEX_FEMALE)
            ->groupBy(Datasets::DIAGNOSIS)
            ->groupBy(Datasets::DATE_OF_EXAMINATION)
            ->get()->toArray()
            ;

        $datasetIll = Datasets::query()
            ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
            ->groupBy(Datasets::DIAGNOSIS)
            // ->groupBy(Datasets::DATE_OF_EXAMINATION)
            ->get()->toArray()
            ;
        $ill = [
            'data' => [],
            'labels' => [],
            'label' => [],
        ];
        foreach($datasetIll as $d) {
            array_push($ill['data'], $d['data']);
            array_push($ill['labels'], $d['label']);
            // array_push($ill['label'], $d['label']);
        }

        // dd($ill);

        // $DefaultResources = new DefaultResources($dataset);
        return response()->json([
            ResponseApi::STATISTICS => $ill,
        ]);
    }

    public function getIll(GetRequest $requestst, Business $business) : JsonResponse
    {
        $dataset = Datasets::query()
            ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
            ->groupBy(Datasets::DIAGNOSIS)
            // ->groupBy(Datasets::DATE_OF_EXAMINATION)
            ->get()->toArray()
        ;
        
        $ill = [
            'data' => [],
            'labels' => [],
            'label' => [],
        ];

        foreach($dataset as $data) {
            array_push($ill['data'], $data['data']);
            array_push($ill['labels'], $data['label']);
            // array_push($ill['label'], $data['label']);
        }

        // $DefaultResources = new DefaultResources($dataset);
        return response()->json([
            ResponseApi::STATISTICS => $ill,
        ]);
    }

    public function getIllSex(GetRequest $requestst, Business $business) : JsonResponse
    {
        $dataset = Datasets::query()
            ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
            ->where(Datasets::SEX, Datasets::SEX_FEMALE)
            ->groupBy(Datasets::DIAGNOSIS)
            // ->groupBy(Datasets::DATE_OF_EXAMINATION)
            ->get()->toArray()
        ;
        
        $ill = [
            'data' => [],
            'labels' => [],
            'label' => [],
        ];

        foreach($dataset as $data) {
            array_push($ill['data'], $data['data']);
            array_push($ill['labels'], $data['label']);
            // array_push($ill['label'], $data['label']);
        }

        // $DefaultResources = new DefaultResources($dataset);
        return response()->json([
            ResponseApi::STATISTICS => $ill,
        ]);
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
