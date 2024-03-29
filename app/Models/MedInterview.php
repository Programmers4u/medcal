<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedInterview extends Model
{
    use SoftDeletes;
    //
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_interview';
    protected $fillable = ['json_data','contact_id'];

    public $contact_id = null;
    public $json_data = null;

    private $json_data_model = null;
    
    public function __construct() {
        parent::__construct();
        $this->json_data_model = $this->defaultDataModel();
        $this->getMedicines();
    }
    
    private function getMedicines(){
        $medicines = MedicalMedicines::query()->select('id','name')->limit(10)->get();
        array_pop($this->json_data_model['aid']);
        foreach($medicines as $i=>$medicine){
            //if($i>10) break;
            $rec = [
            'id' => $medicine['id'],
            'name' => $medicine['name'],
            'value' => false,
            'desc' => '',
            ];
            array_push($this->json_data_model['aid'], $rec);
        }
    }

    private function defaultDataModel(){
        $desc = '';
        $aid = [ 
            [
            'id' => 1,
            'name' => 'Lek na wszystko',
            'value' => false,
            'desc' => '',
            ],
        ];
        $diseases = [
            [
            'id' => '1',
            'name' => trans('medical.interview.diseases.1'),
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.2'),
            'id' => '2',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.3'),
            'id' => '3',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.4'),
            'id' => '4',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.5'),
            'id' => '5',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.6'),
            'id' => '6',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.7'),
            'id' => '7',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.8'),
            'id' => '8',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.9'),
            'id' => '9',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.10'),
            'id' => '10',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.11'),
            'id' => '11',
            'value' => false,
            'desc' => '',
            ],/*
            [
            'name' => trans('medical.interview.diseases.12'),
            'id' => '12',
            'value' => false,
            'desc' => '',
            ],
            [
            'name' => trans('medical.interview.diseases.13'),
            'id' => '13',
            'value' => false,
            'desc' => '',
            ],*/
        ];

        return ['aid' => $aid, 'diseases' => $diseases,'desc' => $desc];
    }
    
    public function getJsonData($contactId) {
        $back = $this->query()->select('json_data')->where('contact_id','=',$contactId)->first();
        if($back != null){
            $back = $back->toArray();
            $back = json_decode($back['json_data']);            

            foreach($this->json_data_model['diseases'] as $indx=>$model){
                if(count($back->diseases) < $indx) break;
                if($model['id']==$back->diseases[$indx]->id)
                    $this->json_data_model['diseases'][$indx]['value']=$back->diseases[$indx]->value;
            }
            
            $this->json_data_model['desc'] = $back->desc;
            
            foreach($this->json_data_model['aid'] as $indx=>$model){
                if(count($back->aid) <= $indx) break;
                if($model['id']==$back->aid[$indx]->id)
                    $this->json_data_model['aid'][$indx]['value']=$back->aid[$indx]->value;
            }
        }
        $_toArray = [];
        foreach($this->json_data_model['diseases'] as $model){
            $_toArray[$model['id']] = $model['name'];
        }
        $_toArrayA = [];
        foreach($this->json_data_model['aid'] as $model){
            $_toArrayA[$model['id']] = $model['name'];
        }
        
        return ['model'=>$this->json_data_model, 'diseases_data' =>  $_toArray, 'aid_data' => $_toArrayA];
    }
    
    public function updateJsonModel($options){
        switch($options['action']){
            case 'sick' : 
                foreach($this->json_data_model['diseases'] as $indx=>$model){
                    if($model['id']==$options['pair']['id'])
                        $this->json_data_model['diseases'][$indx]['value']=$options['pair']['value'];
                }
                break;
            case 'desc' : 
                $this->json_data_model['desc'] = $options['pair']['value'];
                break;
            case 'aid' : 
                foreach($this->json_data_model['aid'] as $indx=>$model){
                    if($model['id']==$options['pair']['id'])
                        $this->json_data_model['aid'][$indx]['value']=$options['pair']['value'];
                }
                break;
        }
        $result = $this->updateOrCreate(['contact_id'=>$options['contact_id']],['contact_id'=>$options['contact_id'],'json_data' => json_encode($this->json_data_model,  JSON_HEX_QUOT) ]);
        return $result;
    }
}
