<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Broadcast extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'schedule_time' => 'array',
            'interval' => 'array',
            'schedule_at' => 'datetime',
            'transferred_at' => 'datetime',
        ];
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(Recipient::class);
    }
}
