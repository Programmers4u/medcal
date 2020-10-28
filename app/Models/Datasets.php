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
    const SEX_MALE = 'male';
    const SEX_FEMALE = 'female';
    const UUID = 'uuid';

    const SEXS = [
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
    ];
    
    // RELATION

    

}
