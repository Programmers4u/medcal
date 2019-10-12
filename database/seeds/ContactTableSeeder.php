<?php

use Illuminate\Database\Seeder;
use Timegridio\Concierge\Models\Contact;
use App\Models\MedPermission;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = $this->getFromFile();
        $businessID = 1;
        foreach ($records as $inx=>$record) {
            //if($inx>0)return;
            $rec = explode(",", $record);
            //dd($rec);
            if(empty($rec[0]) || empty($rec[1]) || !$rec[0] || !$rec[1]) continue;
            $rec[0] = ucfirst($rec[0]);
            $rec[1] = ucfirst($rec[1]);
            if(!empty($rec[4])){
                $contactID = DB::table('contacts')
                        ->select()
                        ->where('mobile',$rec[4])
                        ->where('firstname',$rec[0])
                        ->where('lastname',$rec[1])
                        ->first();
            } else {
                $contactID = DB::table('contacts')
                        ->select()
                        ->where('firstname',$rec[0])
                        ->where('lastname',$rec[1])
                        ->first();
            };
            //dd($contactID);
            if(null==$contactID){
            //dd($rec);
                $contactID = DB::table('contacts')->insert([
                            'firstname'=>$rec[0],
                            'lastname'=>$rec[1],
                            //['birthdate'=>$rec[1],
                            'mobile'=>$rec[4],
                            'email'=>$rec[2],
                            'gender'=>$this->getGender($rec[6]),
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                if($contactID) {
                    $contactID = DB::getPdo()->lastInsertId();
                    //dd($contactID);
                    $_is = DB::table('business_contact')->select()->where('business_id',$businessID)->where('contact_id',$contactID)->count();
                    if(!$_is){
                        //dd($businessID);
                        try{
                        $addcb = DB::table('business_contact')->insert([
                                'business_id'=>$businessID,
                                'contact_id'=>$contactID,
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                                ]);
                        } catch (Exception $e){
                            dd($e->getMessage());
                        }
                        //dd($addcb);
                        $perSMS = (preg_match('/tak/is',$rec[15])) ? TRUE : FALSE;
                        $perSMSN = (preg_match('/tak/is',$rec[17])) ? TRUE : FALSE;
                        $perEMAIL = (preg_match('/tak/is',$rec[16])) ? TRUE : FALSE;
                        $perEMAILN = (preg_match('/tak/is',$rec[18])) ? TRUE : FALSE;
                        $timeAdd = $rec[16];
                        
                        $addmp = DB::table('med_permission')->insert([
                            'business_id'=>$businessID,
                            'contact_id'=>$contactID,
                            'appo_sms' => $perSMS,
                            'news_sms' => $perSMSN,
                            'appo_email' => $perEMAIL,
                            'news_email' => $perEMAILN,
                        ]);
                    }
                }
            }
        }
    }
    
    private function getGender($gender){
        if(preg_match('/czyzna/is',$gender)) return 'M';
        if(preg_match('/obieta/is',$gender)) return 'K';
        return 'M';
    }
    
    private function getFromFile(){
        $filename = dirname(__FILE__).'/seed_file/BAZA.csv';
        $fb = file_get_contents($filename); 
        return explode("\n", $fb);
    }
}
