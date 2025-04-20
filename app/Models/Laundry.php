<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laundry extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $fillable = [
        'name',
        'address',
        'phone'
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
