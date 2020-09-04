<?php

namespace App\Http\Resources;

class Resource
{
    public $toArray = [];

    public function __construct($model)
    {
        $result = $model->get()->toArray();
        $this->toArray = array_map(function($item) {
            return $this->toArray($item);
        }, $result);
    }
    
    public function toArray($item) {
        return $item;
    }
}