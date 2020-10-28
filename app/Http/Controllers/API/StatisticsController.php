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

class StatisticsController extends Controller
{
    const DIAGNOSIS = 'diagnosis';
    const DIAGNOSIS_SEX = 'diagnosis_sex';
    const DIAGNOSIS_PATIENT = 'diagnosis_patient';

    const STATISTICS = [
        self::DIAGNOSIS,
        self::DIAGNOSIS_SEX,
        self::DIAGNOSIS_PATIENT,
    ];

    public function getIndex(GetRequest $request, Business $business) : JsonResponse
    {

        $model = MedicalHistory::query();
        $dataset = null;

        switch($request->input('type')) {
            case self::DIAGNOSIS: 
                $this->setRecords($model);
                $dataset =[ Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(20)
                    ->get()->toArray()
                ];
                // array_push($dataset,['data'=>0,'label'=>'','labels'=>'']);
            break;
            case self::DIAGNOSIS_PATIENT: 

                Datasets::truncate();                    
                $this->setRecords($model);
            
                $modelTwo = Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(20)
                    ->get()->toArray();

                if($request->input('contactId')) {
                    $model->where(MedicalHistory::CONTACT_ID,$request->input('contactId'));
                };
        
                Datasets::truncate();
                $this->setRecords($model);
        
                $modelOne = Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(10)
                    ->get()->toArray()
                    ;
                array_push($modelOne,['data'=>0,'label'=>'','labels'=>'']);
                array_push($modelTwo,['data'=>0,'label'=>'','labels'=>'']);
                $dataset = [$modelOne, $modelTwo];
            break;
            case self::DIAGNOSIS_SEX: 
                $this->setRecords($model);
                $datasetFemale = Datasets::query()
                        ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                        ->where(Datasets::SEX, Datasets::SEX_FEMALE)
                        ->groupBy(Datasets::DIAGNOSIS)
                        // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                        ->havingRaw('data < 100')
                        ->orderBy('data', 'DESC')
                        ->limit(10)
                        ->get()->toArray()
                    ;
                $datasetMale = Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->where(Datasets::SEX, Datasets::SEX_MALE)
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(10)
                    ->get()->toArray()
                ;

                array_push($datasetMale,['data'=>0,'label'=>'','labels'=>'']);
                array_push($datasetFemale,['data'=>0,'label'=>'','labels'=>'']);

                $dataset = [$datasetFemale, $datasetMale];
            break;
            default: 
                $this->setRecords($model);
                $dataset = [Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(10)
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

    private function setRecords($model) : void 
    {
        if(!is_array($model))
            $model = $model->get()->toArray();
        if(Datasets::all()->count() >= count($model)) return;
        foreach($model as $m) {
            $edm = json_decode($m['json_data']);
            $contact = Contact::find($m['contact_id']);
            $birthdate = $contact ? $contact->birthday : '';
            $sex = $contact? $contact->gender : '';
            Datasets::create([
                Datasets::DATE_OF_EXAMINATION  => Carbon::parse($m['created_at']),
                Datasets::BIRTHDAY => Carbon::parse($birthdate),
                Datasets::SEX => $sex === 'M' ? Datasets::SEX_MALE : Datasets::SEX_FEMALE,
                Datasets::DIAGNOSIS => $edm->diagnosis,
                Datasets::PROCEDURES => $edm->procedures,        
            ]);    
        }

    }
}
