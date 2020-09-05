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
use Timegridio\Concierge\Models\Contact;
use Timegridio\Concierge\Presenters\ContactPresenter;

class StatisticsController extends Controller
{
    const DIAGNOSIS = 'diagnosis';
    const DIAGNOSIS_SEX = 'diagnosis_sex';

    const STATISTICS = [
        self::DIAGNOSIS,
        self::DIAGNOSIS_SEX,
    ];

    public function getIndex(GetRequest $request, Business $business) : JsonResponse
    {

        $model = MedicalHistory::query()
            ->get()
            ->toArray()
        ;
        foreach($model as $m) {
            $edm = json_decode($m['json_data']);
            $contact = Contact::find($m['contact_id']);
            $birthdate = $contact->birthday;
            $sex = $contact->gender;
            Datasets::create([
                Datasets::DATE_OF_EXAMINATION  => Carbon::parse($m['created_at']),
                Datasets::BIRTHDAY => Carbon::parse($birthdate),
                Datasets::SEX => $sex === 'M' ? Datasets::SEX_MALE : Datasets::SEX_FEMALE,
                Datasets::DIAGNOSIS => $edm->diagnosis,
                Datasets::PROCEDURES => $edm->procedures,        
            ]);    
        }
        $dataset = null;
        switch($request->input('type')) {
            case self::DIAGNOSIS: 
                $dataset =[ Datasets::query()
                    ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->get()->toArray()
                ];
            break;
            case self::DIAGNOSIS_SEX: 
                $datasetFemale = Datasets::query()
                        ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
                        ->where(Datasets::SEX, Datasets::SEX_FEMALE)
                        ->groupBy(Datasets::DIAGNOSIS)
                        // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                        ->get()->toArray()
                    ;
                $datasetMale = Datasets::query()
                    ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
                    ->where(Datasets::SEX, Datasets::SEX_MALE)
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->get()->toArray()
                ;
                $dataset = [$datasetFemale, $datasetMale];
            break;
            default: 
                $dataset = [Datasets::query()
                    ->selectRaw('Count(1) as data, diagnosis as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->get()->toArray()
            ];
            break;
        }

        // $DefaultResources = new DefaultResources($singleFormat);
        return response()->json([
            ResponseApi::STATISTICS => 
                array_map(function($item) {
                    return $this->make($item);
                },$dataset),
        ]);
    }

    private function make($dataset) {
        $singleFormat = [
            'data' => [],
            'labels' => [],
            'label' => [],
        ];
        foreach($dataset as $data) {
            array_push($singleFormat['data'], $data['data']);
            array_push($singleFormat['labels'], $data['label']);
            array_push($singleFormat['label'], $data['label']);
        }
        return $singleFormat;
    }
}
