<?php

namespace App\Http\Resources\Statistics;

use App\Models\MedicalHistory;
use App\Http\Resources\Resource;

class DefaultResources extends Resource
{
    public function toArray($item) {
        return [
            'label' => $item['label'],
            'data' => $item['data'],
            'labels' => $item['labels'],
        ];
    }
}