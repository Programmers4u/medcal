<?php

namespace App\Http\Resources;

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
                    'status'=> $item->status,
                    'data'=> $item->data,
                    'error'=> $item->error,
                ];
            });
    }
}
