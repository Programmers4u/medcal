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
    protected $fillable = ['name','contacts'];
    
    public static function getGroup($contact_id){
        
        $paginate = MedicalGroup::query()
                ->where('medical_history.contact_id','=',$contact_id)
                ->join('appointments','appointments.id','=','medical_history.appointment_id')
                ->join('humanresources','appointments.humanresource_id','=','humanresources.id')
                ->paginate(5);
        return $paginate;
    }

    public static function getGroups(){
        return MedicalGroup::all();
    }

    public static function putGroup($name, $id){
        $update = ['name'=> $name];
        $query = ['id' => $id];
        //$result = MedicalGroup::create($update);
        $result = MedicalGroup::updateOrCreate($query,$update);
        return $result;
    }    
}
