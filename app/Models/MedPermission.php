<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedPermission extends Model
{
    use SoftDeletes;
    //

    protected $softDelete = true;
    protected $table = 'med_permission';
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['news_email','appo_email','news_sms','appo_sms','contact_id','business_id','json'];

    private $json_data_model = null;
    
    public function __construct() {
        parent::__construct();
        $this->json_data_model = $this->defaultDataModel();
    }

    private function defaultDataModel(){
        return  [
            [
            'name' => trans('medical.interview.permission.appo_sms'),
            'id' => '1',
            'value' => 'true',
            'db' => 'appo_sms',
            ],
            [
            'name' => trans('medical.interview.permission.news_sms'),
            'id' => '2',
            'value' => 'false',
            'db' => 'news_sms',
            ],
            [
            'name' => trans('medical.interview.permission.appo_email'),
            'id' => '3',
            'value' => 'false',
            'db' => 'appo_email',
                
            ],
            [
            'name' => trans('medical.interview.permission.news_email'),
            'id' => '4',
            'value' => 'false',
            'db' => 'news_email',                
            ],
            
        ];
    }
    
    private function setJsonValue($key, $value){
        foreach ($this->json_data_model as $indx=>$model){
            if($key==$model['db']) {
                $this->json_data_model[$indx]['value'] = ($value) ? 'true' : 'false';
                return 0;
            }
        }
    }


    public function getJsonData($contactId){
        $back = $this->query(['news_email','appo_email','news_sms','appo_sms'])->where('contact_id','=',$contactId)->first();
        if($back === null){
            return $this->json_data_model;
        } else {
            $back = $back->toArray();
            foreach ($back as $key=>$db_model){
                $this->setJsonValue($key, $db_model);
            }
            //dd($this->json_data_model);
            return $this->json_data_model;
        }
    }
    
    public function updateJsonModel($options){
        
        foreach($this->json_data_model as $indx=>$model){
            if($model['id']==$options['pair']['id'])
                $this->json_data_model[$indx]['value']=$options['pair']['value'];
        }
        //dd($this->json_data_model);
        $op = ['contact_id'=>$options['contact_id'],'business_id'=>$options['business_id']];
        $update = [
            'contact_id'=>$options['contact_id'],
            'business_id'=>$options['business_id'],
        ];
        foreach($this->json_data_model as $model){
            $update[$model['db']] = ($model['value']=='true') ? true : false;
        }
        //dd($update);
        /*
        $per = $this->query()->where('contact_id','=',$options['contact_id'])->get();
        if($per->count()==0){
            $result = MedPermission::create($update);
        } else {
            $result = $this->update($op,$update);
        }*/
        $result = $this->updateOrCreate($op,$update);
        return $result;
    }    
}
