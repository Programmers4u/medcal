<?php

namespace App\Http\Controllers\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;

class TemplateController extends Controller
{
    //
    
    public function show(Business $business){

        $template= \App\Models\MedicalTemplate::all();
        $template_type[] = trans('medical.template.type.choose');
        $template_type[\App\Models\MedicalTemplate::$typeA] = trans('medical.template.type.a');
        $template_type[\App\Models\MedicalTemplate::$typeQ] = trans('medical.template.type.q');
        return view('medical.template.index', compact('template','business','template_type'));
    }
    
    public function create(Business $business){
        
        $template_type[] = trans('medical.template.type.choose');
        $template_type[\App\Models\MedicalTemplate::$typeA] = trans('medical.template.type.a');
        $template_type[\App\Models\MedicalTemplate::$typeQ] = trans('medical.template.type.q');
        return view('medical.template.create', compact('template_type','business'));
    }
    
    public function edit(Business $business,$tmp_id){
        
        $template = \App\Models\MedicalTemplate::find($tmp_id);
        $template_type[\App\Models\MedicalTemplate::$typeA] = trans('medical.template.type.a');
        $template_type[\App\Models\MedicalTemplate::$typeQ] = trans('medical.template.type.q');
        return view('medical.template.edit', compact('template','template_type','business'));
    }
    
    public function delete(Business $business,$tmp_id){
        $template = \App\Models\MedicalTemplate::destroy($tmp_id);
        return redirect()->route('medical.template.index', [$business]);
    }

    public function store(Request $request){
        if(!$request->input('type') || !$request->input('name')) return 'error';
        $query = ['id' => $request->input('id')];
        $update = ['name' => $request->input('name'),'desc' => $request->input('template'),'type' => $request->input('type')];
        
        $result = \App\Models\MedicalTemplate::updateOrCreate($query,$update);
        
        return $result;
    }
}
