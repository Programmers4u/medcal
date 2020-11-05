<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Datasets extends Model
{
    //
    use SoftDeletes;    

    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    const TABLE = 'datasets';
    const ID = 'id';
    const SEX = 'sex';
    const BIRTHDAY = 'birthday';
    const DATE_OF_EXAMINATION = 'date_of_examination';
    const DIAGNOSIS = 'diagnosis';
    const PROCEDURES = 'procedures';
    const UUID = 'uuid';
    const BUSINESS_ID = 'business_id';

    const SEX_MALE = 'male';
    const SEX_FEMALE = 'female';
    const SEXES = [
        self::SEX_MALE,
        self::SEX_FEMALE,
    ];
    protected $table = self::TABLE;
    
    protected $fillable = [
        self::DATE_OF_EXAMINATION,
        self::DIAGNOSIS,
        self::PROCEDURES,
        self::SEX,
        self::BIRTHDAY,
        self::UUID,
        self::BUSINESS_ID,
    ];
    
    // RELATION
    const RELATION_BUSINESS = 'business';

    public function business() {
        return $this->belongsTo('businesses', self::BUSINESS_ID);
    }
    

}
