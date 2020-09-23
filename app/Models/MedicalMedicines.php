<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalMedicines extends Model
{
    use SoftDeletes;
    //
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_medicines';

    const TABLE = 'medical_medicines';
    const NAME = 'name';
    const SHORT_NAME = 'shortname';
    const POWER = 'power';
    const SHAPE = 'shape';
    const NO_PERMISSION = 'no_permission';
    const PERMISSION_EXPIRED = 'permission_expaired';
    const COMPANY = 'company';
    const TYPE ='type';
    const CODE = 'code';

    protected $fillable = [
        self::NAME,
        self::SHORT_NAME,
        self::POWER,
        self::SHAPE,
        self::NO_PERMISSION,
        self::PERMISSION_EXPIRED,
        self::COMPANY,
        self::TYPE,
        self::CODE,
    ];

}
