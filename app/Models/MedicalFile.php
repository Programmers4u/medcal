<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFile extends Model
{
    //
    use SoftDeletes;    
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'medical_file';
    protected $fillable = ['contact_id','file','description','id','medical_history_id','type','original_name'];
    
    public static $typePermission = 'P';
    public static $typeHistory = 'H';
    public static $typePermissionTemplate = 'PT';

    public static function getFile($contact_id){
        $paginate = MedicalFile::query()
                ->select('id','file','description','type','medical_history_id','original_name')
                ->where('contact_id','=',$contact_id)
                ->paginate(25);
        return $paginate;
    }

    public static function putFile($original_name, $file, $contact_id, $description, $history_id, $type){
        if(!$file || $contact_id<0) return 'error';
        $query = ['contact_id'=>$contact_id,'file'=>$file,'medical_history_id'=>$history_id];
        $update = ['original_name'=>$original_name,'file'=> $file,'description'=>$description,'medical_history_id'=>$history_id,'type'=>$type];
        $result = MedicalFile::updateOrCreate($query,$update);
        return $result;
    }
    
    public static function changeStateFile($file,$type,$history_id){
        $hId = ($type== MedicalFile::$typeHistory) ? 0 : -1;
        $query = ['original_name'=>$file,'medical_history_id'=>$hId];
        $update = ['medical_history_id'=>$history_id,'type'=>$type];
        $result = MedicalFile::query()->where('original_name','=',$file)->where('medical_history_id','=',$hId)->update($update);
        return $result;
    }

    public static function deleteFile($id){
        if(!$id) return 'error';
        $model = MedicalFile::find($id);
        return $model->delete();
    }
}
