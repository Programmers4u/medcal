<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalTemplate extends Model
{
    use SoftDeletes;
    //
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_template';

    const TABLE = 'medical_template';
    const NAME = 'name';
    const TYPE = 'type';
    const DESC = 'desc';

    protected $fillable = [
        self::NAME,
        self::TYPE,
        self::DESC
    ];
    
    public static $typeQ = 'Q';
    public static $typeA = 'A';
}
