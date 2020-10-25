<?php

namespace App\Http\Controllers\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Timegridio\Concierge\Models\Business;
use \App\Models\MedicalTemplates;
use Illuminate\Http\JsonResponse;

class TemplateController extends Controller
{
    
    public function show(Business $business){

        $templates = MedicalTemplates::all();
        $template_type[] = trans('medical.template.type.choose');
        $template_type[MedicalTemplates::TYPE_ANSWER] = trans('medical.template.type.a');
        $template_type[MedicalTemplates::TYPE_QUESTION] = trans('medical.template.type.q');
        return view('medical.template.index', compact('templates','business','template_type'));
    }
    
    public function create(Business $business){
        
        $template_type[] = trans('medical.template.type.choose');
        $template_type[MedicalTemplates::TYPE_ANSWER] = trans('medical.template.type.a');
        $template_type[MedicalTemplates::TYPE_QUESTION] = trans('medical.template.type.q');
        return view('medical.template.create', compact('template_type','business'));
    }
    
    public function edit(Business $business,$tmp_id){
        
        $template = MedicalTemplates::find($tmp_id);
        $template_type[MedicalTemplates::TYPE_ANSWER] = trans('medical.template.type.a');
        $template_type[MedicalTemplates::TYPE_QUESTION] = trans('medical.template.type.q');
        return view('medical.template.edit', compact('template','template_type','business'));
    }
    
    public function delete(Business $business,$tmp_id){
        $template = MedicalTemplates::destroy($tmp_id);
        return redirect()->route('medical.template.index', [$business]);
    }

    public function store(Request $request) : JsonResponse 
    {
        if(!$request->input('post.type') || !$request->input('post.name')) return 'error';
        $query = ['id' => $request->input('id')];
        $update = [
            MedicalTemplates::NAME => $request->input('post.name'), 
            MedicalTemplates::DESCRIPTION => $request->input('post.description'),
            MedicalTemplates::TYPE => $request->input('post.type'),
            MedicalTemplates::BUSINESS_ID => $request->input('post.businessId'),
            MedicalTemplates::DEPENDS => $request->input('post.depends'),
        ];
        
        $result = MedicalTemplates::updateOrCreate($query,$update);
        
        return response()->json([
            'ststus' => 'ok',
            'result' => $result,
        ]);
    }
}
