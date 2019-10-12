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
    protected $fillable = ['name','shortname','power','shape','no_permission','permission_expaired','company','type','code'];
}
