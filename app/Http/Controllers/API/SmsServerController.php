<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SmsServer;

class SmsServerController extends Controller
{
    //
    private $response = ['status'=>'ok','msg'=>null];
    
    public function __construct() {
    }

    private function response($status,$val){
        $this->response = ['status'=>$status,'msg'=>$val];
    }

    public function insert(Request $request){
        $json = json_decode( $request->input('msg') );
        if(-1==$this->jsonPattern(['to','msg'], $json)) {
            $this->response('false', 'missing arg');
        } else {
            $client_id = $request->route()->getParameter('clientId');
            $json->client_id = $client_id;
            $this->response('ok', SmsServer::addSms($json) );
        }
        return response()->json($this->response);
    }

    public function checkToSend(Request $request){
        $clientId = $request->route()->getParameter('clientId');
        if(!$clientId) {
            $this->response('false', 'missing clientId');
            return response()->json($this->response);
        }
        $this->response('ok',SmsServer::getSms($clientId));
        return response()->json($this->response);
    }
    
    public function setStatus(Request $request){
        $json = json_decode( $request->input('msg') );
        $json->client_id = $request->route()->getParameter('clientId');
        if(!$json->client_id) {
            $this->response('false', 'missing clientId');
            return response()->json($this->response);
        }
        if($json->status==='') {
            $this->response('false', 'missing status');
            return response()->json($this->response);
        }
        $this->response('ok',SmsServer::setStatus($json));
        return response()->json($this->response);
    }

    public function getStatus(Request $request){
        $json = json_decode( $request->input('msg') );
        $json->client_id = $request->route()->getParameter('clientId');
        if(!$this->jsonPattern('client_id', $json)) {
            $this->response('false', 'missing clientId');
            return response()->json($this->response);
        }
        if($json->msg_id==='') {
            $this->response('false', 'missing msg_id');
            return response()->json($this->response);
        }
        $this->response('ok',SmsServer::getStatus($json));
        return response()->json($this->response);
    }
    
    private function jsonPattern($pattern,$json) {
        if(is_array($pattern)){
            foreach ($pattern as $pt){
                if(!key_exists($pt, $json)) return -1;
            }
            return 1;
        } else {
            if(!key_exists($pattern, $json)) return -1;
            return 1;
        }
    }
    
}
