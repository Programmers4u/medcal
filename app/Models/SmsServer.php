<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsServer extends Model
{
    //
    use SoftDeletes;
    //
    protected $softDelete = true;
    protected $table = 'sms_server';
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['client_id','to','msg', 'msg_id','status','date_start'];

    public static $STATUS_ERRORR = 0;
    public static $STATUS_TOSEND = 1;
    public static $STATUS_PENDING = 2;
    public static $STATUS_SENT = 3;
    
    /**
     * Add new sms
     * @param json $sms Description
     * @return json Description
     *      */
    public static function addSms($sms) {
        return SmsServer::create (['client_id'=>$sms->client_id,'msg'=>$sms->msg,'to'=>$sms->to,'msg_id'=> md5(microtime())]);
    }
    
    /**
     * getSms
     * @param mixed $client_id Description
     * @return json Description
     */
    public static function getSms($client_id) {
        return json_decode( 
                SmsServer::query()->select(['to','msg','msg_id','status'])
                ->where('client_id','=',$client_id)
                ->where('status','=', SmsServer::$STATUS_TOSEND)
                ->get()
                ->toJson()
                );
    }
    
    /**
     * setStatus - set status by msg_id
     * @param json $json Description
     * @return mixed Description
     */
    public static function setStatus($json){
        return SmsServer::where('msg_id','=',$json->msg_id)
                ->where('client_id','=',$json->client_id)
                ->update(['status'=>$json->status]);
    }
    
    /**
     * getStatus - get status by_msg_id
     * @param json $json Description
     * @return json Description
     */
    public static function getStatus($json){
       return json_decode( 
                SmsServer::query()->select(['msg_id','status'])
                ->where('client_id','=',$json->client_id)
                ->where('msg_id','=', $json->msg_id)
                ->get()
                ->toJson()
                );
    }
}
