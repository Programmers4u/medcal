<?php

namespace App\Http\Resources\MedicalTemplate;

use App\Models\MedicalTemplates;
use Illuminate\Http\Resources\Json\Resource;

class DefaultResources extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->{MedicalTemplates::NAME},
            'description' => $this->{MedicalTemplates::DESCRIPTION},
            'type' => $this->{MedicalTemplates::TYPE},
            'depends' => $this->{MedicalTemplates::DEPENDS}
        ];
    }
}
