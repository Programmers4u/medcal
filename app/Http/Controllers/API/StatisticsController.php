<?php

namespace App\Http\Controllers\API;

use Timegridio\Concierge\Models\Business;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

use App\Http\Consts\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\GetRequest;
use App\Jobs\ProcessDatasetImport;
use App\Models\{
    Datasets,
    MedicalHistory
};
use Carbon\Carbon;

class StatisticsController extends Controller
{
    const DIAGNOSIS = 'diagnosis';
    const DIAGNOSIS_SEX = 'diagnosis_sex';
    const DIAGNOSIS_PATIENT = 'diagnosis_patient';
    
    const BUSINESS_PRICE = 'business_price';

    const STATISTICS = [
        self::DIAGNOSIS,
        self::DIAGNOSIS_SEX,
        self::DIAGNOSIS_PATIENT,
        self::BUSINESS_PRICE,
    ];

    public function getIndex(GetRequest $request, Business $business) : JsonResponse
    {
        $dataset = null;        
        $this->setRecords();

        switch($request->input('type')) {

            case self::DIAGNOSIS: 
                $model = Datasets::query()
                        ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                        ->groupBy(Datasets::DIAGNOSIS)
                        ->havingRaw('data < 100')
                        ->orderBy('data', 'DESC')
                        ->limit(20)
                        // ->get()
                        // ->toArray()
                ;
                $model = Cache::remember(hash::make($model->toSql()), env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use($model) {
                    return $model->get()->toArray();                    
                });
                $dataset = [$model];
            break;
            
            case self::DIAGNOSIS_PATIENT: 
                Cache::flush();
                
                $model = Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(10)
                ;
                
                $modelTwo = $model;

                $model = Cache::remember('patient-diagnosis-all', env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use($model) {
                    return $model->get()->toArray();                    
                });

                if($request->input('contactId')) {
                    $modelTwo->where(Datasets::UUID, $request->input('contactId'));
                };

                $modelTwo = Cache::remember(Hash::make($modelTwo->toSql()), env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use($modelTwo) {
                    return $modelTwo->get()->toArray();                    
                });

                $dataset = [$model, $modelTwo];
            break;
            case self::DIAGNOSIS_SEX: 
                $datasetFemale = Datasets::query()
                        ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                        ->where(Datasets::SEX, Datasets::SEX_FEMALE)
                        ->groupBy(Datasets::DIAGNOSIS)
                        // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                        ->havingRaw('data < 100')
                        ->orderBy('data', 'DESC')
                        ->limit(10)
                        // ->get()
                        // ->toArray()
                    ;
                $datasetFemale = Cache::remember(Hash::make($datasetFemale->toSql()), env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use ($datasetFemale) {
                    return $datasetFemale->get()->toArray();
                });   

                $datasetMale = Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->where(Datasets::SEX, Datasets::SEX_MALE)
                    ->groupBy(Datasets::DIAGNOSIS)
                    // ->groupBy(Datasets::DATE_OF_EXAMINATION)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(10)
                    // ->get()->toArray()
                ;
                $datasetMale = Cache::remember(Hash::make($datasetMale->toSql()), env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use ($datasetMale) {
                    return $datasetMale->get()->toArray();
                });    

                array_push($datasetMale,['data'=>0,'label'=>'','labels'=>'']);
                array_push($datasetFemale,['data'=>0,'label'=>'','labels'=>'']);

                $dataset = [$datasetFemale, $datasetMale];

            break;
            case self::BUSINESS_PRICE: 
                Cache::flush();

                $medicalHistory = MedicalHistory::query()
                    // ->where(MedicalHistory::BUSINESS_ID,$business_id)
                    ->get()
                    // ->toArray()
                ;
                $process = [];
                foreach($medicalHistory as $index => $oneSet) {
                    $mh = json_decode($oneSet->json_data);
                    if(isset($mh->price) && !empty($mh->price))  {
                        $register = array_intersect_key($process, array_intersect(array_column($process, "label"), [substr($oneSet->{MedicalHistory::CREATED_AT},0,7)]));
                        if(!$register) {
                            array_push($process, [ 
                                'data' => $mh->price, 
                                'label' => substr($oneSet->{MedicalHistory::CREATED_AT},0,7),
                                'times' => 1,
                            ]);    
                        } else {
                            // dd($register, $process);
                            $process[key($register)]['data'] += $mh->price;
                            $process[key($register)]['times'] += 1;
                        }
                    }
                };

                $model = $process;
                    
                $modelTwo = $model;
                $process = [];
                foreach($modelTwo as $mt) {
                    // dd($mt);
                    array_push($process, [ 
                        'data' => $mt['data']/$mt['times'], 
                        'label' => $mt['label'],
                    ]);    
                };

                // $model = Cache::remember('business-all', env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use($model) {
                //     return $model->get()->toArray();                    
                // });

                // $modelTwo = Cache::remember(Hash::make($modelTwo->toSql()), env('CACHE_DEFAULT_TIMEOUT_MIN',1), function () use($modelTwo) {
                //     return $modelTwo->get()->toArray();                    
                // });
                $modelTwo = $process;
                $dataset = [ array_slice($model,0,10), array_slice($modelTwo,0,10)];
            break;
            default: 
                $dataset = [
                    Datasets::query()
                    ->selectRaw('Count(1) as data, concat(substring(diagnosis,1,20),"...") as label, created_at as labels')
                    ->groupBy(Datasets::DIAGNOSIS)
                    ->havingRaw('data < 100')
                    ->orderBy('data', 'DESC')
                    ->limit(10)
                    ->get()
                    ->toArray()
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

    private function make($dataset) : array 
    {
        $singleFormat = [
            'data' => [],
            'labels' => [],
            'label' => [],
        ];
        foreach($dataset as $data) {
            if(isset($data['data'])) {
            array_push($singleFormat['data'], $data['data']);
            array_push($singleFormat['labels'], $data['label']);
            array_push($singleFormat['label'], $data['label']);
            }
        }
        return $singleFormat;
    }

    private function setRecords() : void 
    {
        dispatch(new ProcessDatasetImport());
    }
}
