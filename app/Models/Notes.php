<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Matcher\Not;

class Notes extends Model
{
    //
    use SoftDeletes;    
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'notes';
    protected $fillable = ['appointment_id','note'];
    
    /**
     * Save appointment note
     *
     * @param [string] $note
     * @param [number] appointment_id
     * @return new Notes model
     */
     public static function setNote($note, $appointment_id){
        if(!$note || !$appointment_id) return 'error';
        $create = ['note'=>$note,'appointment_id'=> $appointment_id];
        return Notes::create($create);
    }

    
    public static function getNote($appointment_id){
        if(!$appointment_id) return 'error';
        $query = ['appointment_id'=>$appointment_id];
        return Notes::query()
            ->select('note')
            ->where('appointment_id','=',$appointment_id)
            ->get()
            ->toArray()
            ;
    }

}
