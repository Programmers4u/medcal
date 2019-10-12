<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalTemplate extends Model
{
    use SoftDeletes;
    //
    protected $softDelete = true;
    protected $table = 'medical_template';
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['name','type','desc'];
    
    public static $typeQ = 'Q';
    public static $typeA = 'A';
}
