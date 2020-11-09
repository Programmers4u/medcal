<?php

namespace App\Http\Resources\Datasets;

use Illuminate\Http\Resources\Json\Resource;

class DefaultResources extends Resource
{
    public function toArray($item) {
        return [
            'status' => $item['label'],
            'data' => $item['data'],
            'labels' => $item['labels'],
        ];
    }
}