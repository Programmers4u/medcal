<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalGroup extends EloquentModel
{
    use SoftDeletes;    
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_group';
    
    const TABLE = 'medical_group';
    const NAME = 'name';
    const CONTACT_ID = 'contact_id';
    const BUSINESS_ID = 'business_id';

    const NAME_NEW = 'new';
    const NAMES = [
        self::NAME_NEW,
    ];

    protected $fillable = [
        self::NAME,
        self::CONTACT_ID,
        self::BUSINESS_ID,
    ];

    public static function getGroup($contact_id){
        
        $paginate = MedicalGroup::query()
                ->where('medical_history.contact_id','=',$contact_id)
                ->join('appointments','appointments.id','=','medical_history.appointment_id')
                ->join('humanresources','appointments.humanresource_id','=','humanresources.id')
                ->paginate(5);
        return $paginate;
    }

    public static function getGroups($businessId){
        return self::where(self::BUSINESS_ID, $businessId)->get();
    }

    public static function putGroup($name, $businessId, $id) {
        $update = ['name'=> $name, 'business_id' => $businessId];
        $query = ['id' => $id];
        $result = MedicalGroup::updateOrCreate($query,$update);
        return $result;
    }    
}
