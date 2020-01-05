<?php

namespace App\TG;

class smsSender {
        public $to; 
        public $from; 
        public $smsTyp; 
        public $login; 
        public $pass;
        public $pl;
        public $wap;
        public $transaction;
        public $test;
        public $contact;
        public $selfNumber;
        public $secure; 
        public $time;
        public $name;
        public $import;
        public $hlr;
        public $massGroup;
        public $email;
        public $pakiet;
        public $msg_info;
        private $smsConnect;
        private $msg;
        
               
        public function smsSender() {
            $this->smsTyp="sms";
            $this->from="";
            $this->wap="";
            $this->pl=0;      
            $this->test=0;  
            $this->msg_info=0;  
            $this->transaction=0;
            $this->import=0;
            $this->contact=0;
            $this->name="";
            $this->email="";
            $this->pakiet="";
            $this->selfNumber=-1;
            $this->secure=0;
            $this->time=time();
            $this->smsConnect=null;
            $this->Connection();
        }
        
        public function setLogin($login) {
            $this->login=$login;
        }
        
        public function setPass($pass) {
            $this->pass=$pass;
        }
        
        public function setFrom($from) {
            $this->from=$from;
        }
        
        public function setSmsTyp($typ="sms") {
            $this->smsTyp=$typ;
        }
        
        public function setTo($to) {
            $this->to=$to;
        }

        public function setPL($pl) {
            $this->pl=$pl;
        }

        public function setWap($wap) {
            $this->wap=$wap;
        }

        public function setTest($test=1) {
            $this->test=$test;
        }

        public function setContact($contact=1) {
            $this->contact=$contact;
        }

        public function setTransaction($transaction=1) {
            $this->transaction=$transaction;
        }

        public function setTime($data='') {//eg. 2010-10-06 23:45:00
            if($data) {
                $d=explode(" ",$data);
                $h=explode(":",$d[1]);
                $d=explode("-",$d[0]);
                $this->time=mktime($h[0],$h[1],$h[2],$d[1],$d[2],$d[0]);
            };
        }

        public function setSelfNumber($number=-1) {
            $this->selfNumber=$number;
        }
        
        public function setMsg($msg) {
            $replacement = array(
                "&"=>"%26",
                "#"=>"%23",
                " "=>"%20"
            );
            $this->msg=($this->smsTyp!='premium') ? strtr($msg,$replacement) : $msg;    
        }
        
        public function ChangeServer($id) {
            $this->server=$id;    
        }
        
        private function GetServers() {
            $url="http://www.gatesms.eu/sms_api.php?server_get_log_ip=1";
            $header[0] = "Connection: keep-alive";
            $header[1] = "Keep-Alive: 300";        
            
            $smsConnect = curl_init();    
            curl_setopt($smsConnect, CURLOPT_HTTPHEADER, $header);                       
            curl_setopt($smsConnect, CURLOPT_POST, 1);
            curl_setopt($smsConnect, CURLOPT_USERAGENT, "SMSbot:(www.gatesms.eu)");
            curl_setopt($smsConnect, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($smsConnect, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($smsConnect, CURLOPT_TIMEOUT, 15);
            curl_setopt($smsConnect, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($smsConnect, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($smsConnect, CURLOPT_URL, $url);
            array_push($this->servers,curl_exec($smsConnect).'/gatesms');
            curl_close($smsConnect);
        }
        
        private function Connection() {
            
            $url=($this->secure)?"https://gatesms.eu/sms_api.php":"http://gatesms.eu/sms_api.php";
            $header[0] = "Connection: keep-alive";
            $header[1] = "Keep-Alive: 300";        

            if(!$this->smsConnect) { 
                //$this->GetServers();
                $this->smsConnect = curl_init($url);    
                if($this->secure) curl_setopt($this->smsConnect, CURLOPT_SSL_VERIFYPEER, 0);         
                curl_setopt($this->smsConnect, CURLOPT_HTTPHEADER, $header);                       
                curl_setopt($this->smsConnect, CURLOPT_POST, 1);
                curl_setopt($this->smsConnect, CURLOPT_USERAGENT, "SMSbot:(www.gatesms.eu)");
                curl_setopt($this->smsConnect, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($this->smsConnect, CURLOPT_FRESH_CONNECT, 1);
                curl_setopt($this->smsConnect, CURLOPT_TIMEOUT, 15);
                curl_setopt($this->smsConnect, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($this->smsConnect, CURLOPT_RETURNTRANSFER, 1); 
                //curl_setopt($this->smsConnect, CURLOPT_URL, $url);
            };    
        }
        
        public function checkNumber($number) {
            $out="";
            $fields="spr_numer=".$number;
            $fields.="&full=1";
            if(!$this->smsConnect) $this->Connection();            
            curl_setopt($this->smsConnect, CURLOPT_POSTFIELDS, $fields);
            $out=curl_exec($this->smsConnect);
            return $out;
        }
        
        public function checkCredit() {
            $out="";
            $fields="login=".$this->login;
            $fields.="&pass=".$this->pass;
            $fields.="&check_credit=1";                                     
            if(!$this->smsConnect) $this->Connection();
            curl_setopt($this->smsConnect, CURLOPT_POSTFIELDS, $fields);
            $out=curl_exec($this->smsConnect);
            return $out;
        }
        
        public function sendSms() {
            $out="";
            $fields="login=".$this->login;
            $fields.="&pass=".$this->pass;
            if($this->pakiet=='') {
                $fields.="&msg=".$this->msg; 
                $fields.="&to=".$this->to;
            } else {
                $fields.="&pakiet=".$this->pakiet;
            };
            $fields.="&test=".$this->test; 
            if(!empty($this->from)){
                $fields.="&from=".$this->from;
            };
            $fields.="&self_number=".$this->selfNumber; 
            /*
            $fields.="&sms_type=".$this->smsTyp;
            $fields.="&pl=".$this->pl; 
            $fields.="&wap=".$this->wap; 
            $fields.="&transaction=".$this->transaction; 
            $fields.="&msg_info=".$this->msg_info; 
            $fields.="&contact=".$this->contact; 
            $fields.="&time=".$this->time;             
            $fields.="&name=".$this->name;
            $fields.="&import=".$this->import;             
            $fields.="&email=".$this->email;                                      
            */
            if(!$this->smsConnect) $this->Connection();
            curl_setopt($this->smsConnect, CURLOPT_POSTFIELDS, $fields);
            $out=curl_exec($this->smsConnect);
            return $out;
        }

        public function ConectClose() {
            if($this->smsConnect) curl_close($this->smsConnect);
        }
        
        private function __desctruct() {
            $this->ConnectClose();
        }
};