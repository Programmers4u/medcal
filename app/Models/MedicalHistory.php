<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
class MedicalHistory extends EloquentModel
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_history';

    const TABLE = 'medical_history';
    const JSON_DATA  = 'json_data';
    const CONTACT_ID = 'contact_id';
    const APPOINTMENT_ID = 'appointment_id';
    const HUMANRESOURCES_ID = 'humanresources_id';

    protected $fillable = [
        self::JSON_DATA,
        self::CONTACT_ID,
        self::APPOINTMENT_ID,
        self::HUMANRESOURCES_ID,
    ];
    
    public static function getHistory($contact_id){
        $paginate = MedicalHistory::query()
                ->select('json_data','medical_history.id as history','appointment_id','medical_history.created_at','medical_history.updated_at','humanresources.name','appointments.start_at')//,'start_at'
                ->where('medical_history.contact_id','=',$contact_id)
                ->orderBy('appointments.start_at','DESC')
                ->leftJoin('appointments','appointments.id','=','medical_history.appointment_id')
                ->leftjoin('humanresources','medical_history.humanresources_id','=','humanresources.id')
                ->paginate(100);
        //dd($paginate->total());
        return $paginate;
    }

    public static function putHistory($data, $contact_id, $appointment_id, $staff){
        if(!$contact_id || !$staff) return 'error parametres';
        $create = ['humanresources_id'=>$staff,'json_data'=> json_encode($data,JSON_HEX_QUOT),'appointment_id'=>$appointment_id,'contact_id'=>$contact_id];
        $result = MedicalHistory::create($create);
        if(isset($data['files'])){
            foreach ($data['files'] as $j){
                MedicalFile::changeStateFile($j, 'H', $result->id);
            }
        }
        return $result;
    }

    public static function updateHistory($data, $contact_id, $appointment_id, $staff){
        if(!$appointment_id || !$contact_id || !$staff) return 'error parametres';
        $query = ['contact_id'=>$contact_id,'medical_history.id'=>$appointment_id];
        $update = ['humanresources_id'=>$staff,'json_data'=> json_encode($data,JSON_HEX_QUOT),'contact_id'=>$contact_id];
        $result = MedicalHistory::updateOrCreate($query,$update);
        if(isset($data['files'])){
            foreach ($data['files'] as $j){
                MedicalFile::changeStateFile($j, 'H', $appointment_id);
            }
        }
        return $result;
    }

    /**
     * has Contacts.
     *
     *      Contacts are the different profiles for different Businesses the User may have
     *
     * @return Illuminate\Database\Query Relationship User has Contacts query
     */
    public function contacts()
    {
        return $this->belongsTo(\Timegridio\Concierge\Models\Contact::class);
    }

    /**
     * has Contacts.
     *
     * @return bool The User has at least one Contact profile set
     */
    public function hasContacts()
    {
        return $this->contacts->count() > 0;
    }    
    
    public static function json_data_schem(){
        return [
            'procedures' => '',
            'edit_procedures' => '',
            'diagnosis' => '',
            'edit_diagnosis' => '',
            'edit_staff' => '',
            'edit_reason' => '',
            'files' => '',
            'note' => '',
            'price' => '',
        ];        
    }
}
