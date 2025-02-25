<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids,HasApiTokens;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'laundry_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the laundry that owns the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function laundry()
    {
        return $this->belongsTo(Laundry::class);
    }
}
