<?php

namespace App\Http\Resources\Medicines;

use App\Models\MedicalMedicines;
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
        return $this->map(function($item){
                return [
                    'id' => $item->{MedicalMedicines::ID},
                    'text' => $item->{MedicalMedicines::SHORT_NAME},
                ];
            });
    }
}
