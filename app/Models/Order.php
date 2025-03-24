<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $fillable = [
        'customer_id',
        'laundry_id',
        'status',
        'type',
        'barcode',
        'weight',
        'total_price',
        'note',
        'order_date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function laundry()
    {
        return $this->belongsTo(Laundry::class);
    }
}
