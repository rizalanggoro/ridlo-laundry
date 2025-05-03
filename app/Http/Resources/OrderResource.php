<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'customer' => [
                'id' => (string) $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'username' => $this->customer->username,
            ],
            'laundry' => [
                'id' => (string) $this->laundry->id,
                'name' => $this->laundry->name,
                'phone' => $this->laundry->phone,
            ],
            'service' => [
                'id' => (string) $this->service->id,
                'name' => $this->service->name,
                'description' => $this->service->description,
            ],
            'status' => $this->status,
            'barcode' => $this->barcode,
            'weight' => $this->weight,
            'total_price' => $this->total_price,
            'note' => $this->note,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'order_date' => $this->order_date,
        ];
    }
}
