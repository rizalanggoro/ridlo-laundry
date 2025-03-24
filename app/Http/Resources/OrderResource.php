<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'orders',
            'id' => (string) $this->id,
            'attributes' => [
                'status' => $this->status,
                'type' => $this->type,
                'barcode' => $this->barcode,
                'weight' => $this->weight,
                'total_price' => $this->total_price,
                'note' => $this->note,
                'created_at' => $this->created_at->toISOString(),
                'updated_at' => $this->updated_at->toISOString(),
                'order_date' => $this->order_date,
            ],
            'relationships' => [
                'customer' => [
                    'data' => [
                        'type' => 'customers',
                        'id' => (string) $this->customer->id,
                    ],
                ],
                'laundry' => [
                    'data' => [
                        'type' => 'laundries',
                        'id' => (string) $this->laundry->id,
                    ],
                ],
            ],
            'included' => [
                [
                    'type' => 'customers',
                    'id' => (string) $this->customer->id,
                    'attributes' => [
                        'name' => $this->customer->name,
                        'phone' => $this->customer->phone,
                    ],
                ],
                [
                    'type' => 'laundries',
                    'id' => (string) $this->laundry->id,
                    'attributes' => [
                        'name' => $this->laundry->name,
                    ],
                ],
            ],
        ];
    }
}
