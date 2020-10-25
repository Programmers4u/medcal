<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Timegridio\Concierge\Models\Business;

class MedicalTemplates extends Model
{
    use SoftDeletes;
    //
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_templates';

    const TABLE = 'medical_templates';
    const NAME = 'name';
    const TYPE = 'type';
    const DESCRIPTION = 'description';
    const BUSINESS_ID = 'business_id';
    const DEPENDS = 'depends';

    const TYPE_QUESTION = 'Q';
    const TYPE_ANSWER = 'A';
    const TYPES = [
        self::TYPE_ANSWER,
        self::TYPE_QUESTION,
    ];

    protected $fillable = [
        self::NAME,
        self::TYPE,
        self::DESCRIPTION,
        self::BUSINESS_ID,
        self::DEPENDS,
    ];

    const RELATION_BUSINESS = 'business';

    public function business() {
        return $this->belongsTo(Business::class, self::BUSINESS_ID);
    }
    
}
