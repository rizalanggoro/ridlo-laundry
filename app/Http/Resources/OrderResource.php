<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
            ],
            'laundry' => [
                'id' => $this->laundry->id,
                'name' => $this->laundry->name,
            ],
            'status' => $this->status,
            'type' => $this->type,
            'barcode' => $this->barcode,
            'weight' => $this->weight,
            'total_price' => $this->total_price,
            'note' => $this->note,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
