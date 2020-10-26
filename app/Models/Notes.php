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
    const BUSINESS_ID = 'business_id';
    const CONTACT_ID = 'contact_id';

    protected $table = self::TABLE;
    protected $fillable = [
        self::APPOINTMENT_ID,
        self::NOTE,
        self::BUSINESS_ID,
        self::CONTACT_ID,
    ];
    
    public static function setNote($note, $appointment_id, $businessId, $contactId) {
        return Notes::updateOrCreate([
            self::APPOINTMENT_ID => $appointment_id,
            self::NOTE => $note,
            self::BUSINESS_ID => $businessId,
            self::CONTACT_ID => $contactId,
        ]);
    }

    public static function getNote($appointmentId, $businessId, $contactId) {
        if(!$businessId) return null;
        return Notes::where(Notes::BUSINESS_ID, $businessId)
            ->where(Notes::CONTACT_ID, $contactId)
            // ->where('appointment_id', $appointmentId)
            ->pluck('note')
            ;
    }

    // RELATION

    const RELATION_APPOINTMENT = 'appointment';

    public function appointment() {
        return $this->belongsTo('appointments.id', self::APPOINTMENT_ID);
    }

    const RELATION_BUSINESS = 'business';

    public function business() {
        return $this->belongsTo('businesses.id', self::BUSINESS_ID);
    }

    const RELATION_CONTACT = 'contact';

    public function contact() {
        return $this->belongsTo('contacts.id', self::CONTACT_ID);
    }
}
