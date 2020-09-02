<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notes extends Model
{
    //
    use SoftDeletes;    

    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    const TABLE = 'notes';
    const ID = 'id';
    const APPOINTMENT_ID = 'appointment_id';
    const NOTE = 'note';

    protected $table = self::TABLE;
    protected $fillable = [
        self::APPOINTMENT_ID,
        self::NOTE
    ];
    
    public static function setNote($note, $appointment_id) {
        return Notes::updateOrCreate([
            self::APPOINTMENT_ID => $appointment_id,
            self::NOTE => $note,
        ]);
    }

    public static function getNote($appointment_id){
        return Notes::query()
            ->where('appointment_id',$appointment_id)
            ->pluck('note')
            ;
    }

    // RELATION

    const RELATION_APPOINTMENT = 'appointment';

    public function appointment() {
        return $this->belongsTo('appointments.id', self::APPOINTMENT_ID);
    }


}
